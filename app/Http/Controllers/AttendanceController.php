<?php

namespace App\Http\Controllers;

use App\Models\ClassInstance;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Show today's attendance
     */
    public function today()
    {
        $today = Carbon::today();
        $dayOfWeek = strtolower($today->format('l'));

        // Get all class instances for today
        $classInstances = ClassInstance::with(['schedule', 'trainer', 'course', 'member'])
            ->whereDate('start_date', $today)
            ->where('status', 'scheduled')
            ->orderBy('start_time')
            ->get();

        // Get members who should be in class today
        $expectedMembers = [];
        $presentMembers = [];
        $absentMembers = [];

        foreach ($classInstances as $class) {
            foreach ($class->member as $member) {
                $attendanceStatus = $member->pivot->attendance_status ?? 'not_marked';

                $expectedMembers[] = [
                    'class' => $class,
                    'member' => $member,
                    'status' => $attendanceStatus,
                    'check_in' => $member->pivot->check_in_time,
                    'check_out' => $member->pivot->check_out_time,
                ];

                if ($attendanceStatus == 'present' || $attendanceStatus == 'late') {
                    $presentMembers[] = $member;
                } elseif ($attendanceStatus == 'absent') {
                    $absentMembers[] = $member;
                }
            }
        }

        $stats = [
            'total_classes' => $classInstances->count(),
            'total_expected' => count($expectedMembers),
            'total_present' => count($presentMembers),
            'total_absent' => count($absentMembers),
            'attendance_rate' => count($expectedMembers) > 0
                ? round((count($presentMembers) / count($expectedMembers)) * 100, 2)
                : 0
        ];

        return view('attendance.today', compact('classInstances', 'expectedMembers', 'stats', 'today'));
    }

    /**
     * Show calendar view for attendance
     */
    public function calendar(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Get all class instances for the month
        $classInstances = ClassInstance::with(['schedule', 'trainer', 'course'])
            ->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->where('status', 'scheduled')
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($instance) {
                return Carbon::parse($instance->start_date)->format('Y-m-d');
            });

        // Build calendar days
        $calendar = [];
        $currentDate = clone $startDate;

        while ($currentDate->lte($endDate)) {
            $dateKey = $currentDate->format('Y-m-d');
            $dayData = [
                'date' => $currentDate->format('Y-m-d'),
                'day_name' => $currentDate->format('l'),
                'is_today' => $currentDate->isToday(),
                'is_weekend' => $currentDate->isWeekend(),
                'classes' => $classInstances->get($dateKey, collect()),
                'total_classes' => $classInstances->get($dateKey, collect())->count(),
            ];

            $calendar[] = $dayData;
            $currentDate->addDay();
        }

        // Get month info
        $prevMonth = Carbon::createFromDate($year, $month, 1)->subMonth();
        $nextMonth = Carbon::createFromDate($year, $month, 1)->addMonth();

        return view('attendance.calendar', compact('calendar', 'month', 'year', 'prevMonth', 'nextMonth', 'startDate', 'endDate'));
    }

    /**
     * Show member attendance history
     */
    public function memberHistory($memberId)
    {
        $member = Member::with(['schedules.course', 'schedules.trainer'])->findOrFail($memberId);

        // Get all class instances this member attended
        $attendances = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('schedules', 'class_instances.schedule_id', '=', 'schedules.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('trainers', 'schedules.trainer_id', '=', 'trainers.id')
            ->where('class_instance_member.member_id', $memberId)
            ->select(
                'class_instances.*',
                'class_instance_member.attendance_status',
                'class_instance_member.check_in_time',
                'class_instance_member.check_out_time',
                'class_instance_member.duration_minutes',
                'courses.name as course_name',
                'trainers.name as trainer_name'
            )
            ->orderBy('class_instances.start_date', 'desc')
            ->orderBy('class_instances.start_time', 'desc')
            ->paginate(15);

        // Calculate statistics
        $stats = [
            'total_classes' => $attendances->total(),
            'present' => DB::table('class_instance_member')
                ->where('member_id', $memberId)
                ->whereIn('attendance_status', ['present', 'late'])
                ->count(),
            'absent' => DB::table('class_instance_member')
                ->where('member_id', $memberId)
                ->where('attendance_status', 'absent')
                ->count(),
            'not_marked' => DB::table('class_instance_member')
                ->where('member_id', $memberId)
                ->whereNull('attendance_status')
                ->count(),
        ];

        $stats['attendance_rate'] = $stats['total_classes'] > 0
            ? round(($stats['present'] / $stats['total_classes']) * 100, 2)
            : 0;

        // Get monthly attendance chart data
        $monthlyData = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->where('class_instance_member.member_id', $memberId)
            ->select(
                DB::raw('DATE_FORMAT(class_instances.start_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN class_instance_member.attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as present')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('attendance.member_history', compact('member', 'attendances', 'stats', 'monthlyData'));
    }

    /**
     * Show attendance for a specific class instance
     */
    public function classAttendance($classInstanceId)
    {
        $classInstance = ClassInstance::with([
            'schedule',
            'trainer',
            'course',
            'member' => function ($query) {
                $query->orderBy('name');
            }
        ])->findOrFail($classInstanceId);

        // Get all enrolled members from the schedule
        $enrolledMembers = $classInstance->schedule->member()
            ->wherePivot('status', 'active')
            ->wherePivot('enrolled_date', '<=', $classInstance->start_date)
            ->where(function ($query) use ($classInstance) {
                $query->whereNull('member_schedule.expiry_date')
                    ->orWhere('member_schedule.expiry_date', '>=', $classInstance->start_date);
            })
            ->orderBy('name')
            ->get();

        // Mark which members are already in the attendance table
        $attendance = [];
        foreach ($enrolledMembers as $member) {
            $attended = $classInstance->member->contains('id', $member->id);
            $attendance[] = [
                'member' => $member,
                'is_marked' => $attended,
                'attendance_status' => $attended ? $member->pivot->attendance_status : null,
                'check_in_time' => $attended ? $member->pivot->check_in_time : null,
                'check_out_time' => $attended ? $member->pivot->check_out_time : null,
            ];
        }

        // Statistics for this class
        $stats = [
            'total_enrolled' => $enrolledMembers->count(),
            'present' => $classInstance->member->where('pivot.attendance_status', 'present')->count(),
            'late' => $classInstance->member->where('pivot.attendance_status', 'late')->count(),
            'absent' => $classInstance->member->where('pivot.attendance_status', 'absent')->count(),
            'not_marked' => $enrolledMembers->count() - $classInstance->member->count(),
        ];

        return view('attendance.class_attendance', compact('classInstance', 'attendance', 'stats'));
    }

    /**
     * Mark attendance for a class instance
     */
    public function markAttendance(Request $request, $classInstanceId)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.member_id' => 'required|exists:members,id',
            'attendance.*.status' => 'nullable|in:present,absent,late',
            'attendance.*.check_in' => 'nullable|date_format:H:i',
            'attendance.*.check_out' => 'nullable|date_format:H:i',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Find the class instance
            $classInstance = ClassInstance::findOrFail($classInstanceId);

            if (!$classInstance) {
                throw new \Exception('Class instance not found');
            }

            foreach ($request->attendance as $data) {
                $memberId = $data['member_id'];
                $status = $data['status'] ?? null;
                $checkIn = $data['check_in'] ?? null;
                $checkOut = $data['check_out'] ?? null;
                $notes = $data['notes'] ?? null;

                // Calculate duration if both check-in and check-out exist
                $duration = null;
                if ($checkIn && $checkOut) {
                    $checkInTime = Carbon::createFromFormat('H:i', $checkIn);
                    $checkOutTime = Carbon::createFromFormat('H:i', $checkOut);

                    if ($checkOutTime->gt($checkInTime)) {
                        $duration = $checkOutTime->diffInMinutes($checkInTime);
                    }
                }

                // Check if the relationship exists
                $exists = DB::table('class_instance_member')
                    ->where('class_instance_id', $classInstanceId)
                    ->where('member_id', $memberId)
                    ->exists();

                if ($exists) {
                    // Update existing record using DB facade to avoid model issues
                    DB::table('class_instance_member')
                        ->where('class_instance_id', $classInstanceId)
                        ->where('member_id', $memberId)
                        ->update([
                            'attendance_status' => $status,
                            'check_in_time' => $checkIn,
                            'check_out_time' => $checkOut,
                            'duration_minutes' => $duration,
                            'note' => $notes,
                            'marked_by' => Auth::id(),
                            'updated_at' => now(),
                        ]);
                } else {
                    // Insert new record
                    DB::table('class_instance_member')->insert([
                        'class_instance_id' => $classInstanceId,
                        'member_id' => $memberId,
                        'attendance_status' => $status,
                        'check_in_time' => $checkIn,
                        'check_out_time' => $checkOut,
                        'duration_minutes' => $duration,
                        'note' => $notes,
                        'marked_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Update available spots - with error handling
            try {
                if (method_exists($classInstance, 'updateAvailableSpots')) {
                    $classInstance->updateAvailableSpots();
                } else {
                    // Manual update if method doesn't exist
                    $currentAttendees = DB::table('class_instance_member')
                        ->where('class_instance_id', $classInstanceId)
                        ->count();

                    DB::table('class_instances')
                        ->where('id', $classInstanceId)
                        ->update([
                            'available_spots' => max(0, $classInstance->total_spots - $currentAttendees)
                        ]);
                }
            } catch (\Exception $e) {
                Log::warning('Could not update available spots: ' . $e->getMessage());
                // Continue execution - don't fail the whole transaction
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Attendance marked successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'Attendance marked successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Attendance marking error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error marking attendance: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error marking attendance: ' . $e->getMessage());
        }
    }

    /**
     * Bulk mark attendance for multiple class instances
     */
    public function bulkMarkAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.class_instance_id' => 'required|exists:class_instances,id',
            'attendance.*.member_id' => 'required|exists:members,id',
            'attendance.*.status' => 'nullable|in:present,absent,late',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->attendance as $data) {
                $classInstanceId = $data['class_instance_id'];
                $memberId = $data['member_id'];
                $status = $data['status'] ?? null;

                // Update or create attendance record
                DB::table('class_instance_member')
                    ->updateOrInsert(
                        [
                            'class_instance_id' => $classInstanceId,
                            'member_id' => $memberId,
                        ],
                        [
                            'attendance_status' => $status,
                            'marked_by' => Auth::id(),
                            'updated_at' => now(),
                        ]
                    );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bulk attendance marked successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error marking bulk attendance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check-in a member
     */
    public function checkIn($classInstanceId, $memberId)
    {
        try {
            $now = now()->format('H:i:s');

            // Use DB facade directly to avoid model issues
            DB::table('class_instance_member')
                ->updateOrInsert(
                    [
                        'class_instance_id' => $classInstanceId,
                        'member_id' => $memberId,
                    ],
                    [
                        'check_in_time' => $now,
                        'attendance_status' => 'present',
                        'marked_by' => Auth::id(),
                        'updated_at' => now(),
                    ]
                );

            // Update available spots
            $classInstance = ClassInstance::find($classInstanceId);
            if ($classInstance) {
                $classInstance->updateAvailableSpots();
            }

            return response()->json([
                'success' => true,
                'message' => 'Member checked in successfully!',
                'check_in_time' => $now
            ]);
        } catch (\Exception $e) {
            Log::error('Check-in error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error checking in: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Check-out a member
     */
    public function checkOut($classInstanceId, $memberId)
    {
        try {
            $now = now()->format('H:i');

            // Get check-in time to calculate duration
            $record = DB::table('class_instance_member')
                ->where('class_instance_id', $classInstanceId)
                ->where('member_id', $memberId)
                ->first();

            $duration = null;
            if ($record && $record->check_in_time) {
                $checkIn = Carbon::createFromFormat('H:i', $record->check_in_time);
                $checkOut = Carbon::createFromFormat('H:i', $now);
                $duration = $checkOut->diffInMinutes($checkIn);
            }

            DB::table('class_instance_member')
                ->where('class_instance_id', $classInstanceId)
                ->where('member_id', $memberId)
                ->update([
                    'check_out_time' => $now,
                    'duration_minutes' => $duration,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Member checked out successfully!',
                'check_out_time' => $now,
                'duration' => $duration
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking out: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export attendance report
     */
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'in:csv,excel,pdf'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $format = $request->get('format', 'csv');

        // Get attendance data
        $data = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('members', 'class_instance_member.member_id', '=', 'members.id')
            ->join('schedules', 'class_instances.schedule_id', '=', 'schedules.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('trainers', 'schedules.trainer_id', '=', 'trainers.id')
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'class_instances.start_date',
                'class_instances.start_time',
                'class_instances.end_time',
                'members.name as member_name',
                'members.code as member_code',
                'courses.name as course_name',
                'trainers.name as trainer_name',
                'class_instance_member.attendance_status',
                'class_instance_member.check_in_time',
                'class_instance_member.check_out_time',
                'class_instance_member.duration_minutes'
            )
            ->orderBy('class_instances.start_date')
            ->orderBy('class_instances.start_time')
            ->get();

        // Generate filename
        $filename = "attendance_report_{$startDate}_to_{$endDate}";

        if ($format == 'csv') {
            return $this->exportCSV($data, $filename);
        } elseif ($format == 'excel') {
            return $this->exportExcel($data, $filename);
        } else {
            return $this->exportPDF($data, $filename);
        }
    }

    /**
     * Export as CSV
     */
    private function exportCSV($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}.csv",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'Date',
                'Start Time',
                'End Time',
                'Member Name',
                'Member Code',
                'Course',
                'Trainer',
                'Status',
                'Check In',
                'Check Out',
                'Duration (mins)'
            ]);

            // Add data
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->start_date,
                    $row->start_time,
                    $row->end_time,
                    $row->member_name,
                    $row->member_code,
                    $row->course_name,
                    $row->trainer_name,
                    $row->attendance_status ?? 'not_marked',
                    $row->check_in_time,
                    $row->check_out_time,
                    $row->duration_minutes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export as Excel (simplified - you can use Laravel Excel package for better)
     */
    private function exportExcel($data, $filename)
    {
        // For simplicity, just return CSV
        return $this->exportCSV($data, $filename);
    }

    /**
     * Export as PDF (simplified - you'd need a package like dompdf)
     */
    private function exportPDF($data, $filename)
    {
        // You'd implement PDF generation here
        // For now, return CSV
        return $this->exportCSV($data, $filename);
    }

    /**
     * Attendance statistics dashboard
     */
    public function statistics(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Overall statistics
        $overall = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN attendance_status = "present" THEN 1 ELSE 0 END) as present'),
                DB::raw('SUM(CASE WHEN attendance_status = "late" THEN 1 ELSE 0 END) as late'),
                DB::raw('SUM(CASE WHEN attendance_status = "absent" THEN 1 ELSE 0 END) as absent'),
                DB::raw('SUM(CASE WHEN attendance_status IS NULL THEN 1 ELSE 0 END) as not_marked')
            )
            ->first();

        // Attendance by course
        $byCourse = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('schedules', 'class_instances.schedule_id', '=', 'schedules.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'courses.name as course_name',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as attended')
            )
            ->groupBy('courses.id', 'courses.name')
            ->get();

        // Attendance by trainer
        $byTrainer = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('trainers', 'class_instances.trainer_id', '=', 'trainers.id')
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'trainers.name as trainer_name',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as attended')
            )
            ->groupBy('trainers.id', 'trainers.name')
            ->get();

        // Daily attendance trend
        $dailyTrend = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'class_instances.start_date',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as attended')
            )
            ->groupBy('class_instances.start_date')
            ->orderBy('class_instances.start_date')
            ->get();

        // Top members by attendance
        $topMembers = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('members', 'class_instance_member.member_id', '=', 'members.id')
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'members.id',
                'members.name',
                'members.code',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as attended')
            )
            ->groupBy('members.id', 'members.name', 'members.code')
            ->orderByDesc('attended')
            ->limit(10)
            ->get();

        return view('attendance.statistics', compact(
            'overall',
            'byCourse',
            'byTrainer',
            'dailyTrend',
            'topMembers',
            'startDate',
            'endDate'
        ));
    }
}
