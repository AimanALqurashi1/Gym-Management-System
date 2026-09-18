<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\ClassInstance;
use App\Models\Member;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainerDashboardController extends Controller
{
    /**
     * Show trainer dashboard
     */
    public function dashboard()
    {
        $trainer = Auth::user()->trainer ?? null;

        if (!$trainer) {
            return redirect()->route('home')->with('error', 'Trainer profile not found');
        }

        // Today's classes
        $todayClasses = ClassInstance::with(['course', 'schedule', 'member'])
            ->where('trainer_id', $trainer->id)
            ->whereDate('start_date', today())
            ->orderBy('start_time')
            ->get()
            ->map(function ($class) {
                $class->total_enrolled = $class->member->count();
                $class->present_count = $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();
                return $class;
            });

        // Upcoming classes (next 7 days)
        $upcomingClasses = ClassInstance::with(['course', 'schedule'])
            ->where('trainer_id', $trainer->id)
            ->whereBetween('start_date', [today()->addDay(), today()->addDays(7)])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Recent attendance
        $recentAttendance = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('members', 'class_instance_member.member_id', '=', 'members.id')
            ->join('courses', 'class_instances.course_id', '=', 'courses.id')
            ->where('class_instances.trainer_id', $trainer->id)
            ->whereNotNull('class_instance_member.attendance_status')
            ->orderBy('class_instance_member.updated_at', 'desc')
            ->limit(10)
            ->select(
                'class_instances.start_date',
                'class_instances.start_time',
                'courses.name as course_name',
                'members.name as member_name',
                'members.photo',
                'class_instance_member.attendance_status',
                'class_instance_member.check_in_time',
                'class_instance_member.updated_at'
            )
            ->get();

        // Statistics
        $stats = [
            'total_classes' => ClassInstance::where('trainer_id', $trainer->id)->count(),
            'total_members' => DB::table('class_instance_member')
                ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                ->where('class_instances.trainer_id', $trainer->id)
                ->distinct('class_instance_member.member_id')
                ->count('class_instance_member.member_id'),
            'classes_this_month' => ClassInstance::where('trainer_id', $trainer->id)
                ->whereMonth('start_date', now()->month)
                ->count(),
            'attendance_rate' => $this->calculateAttendanceRate($trainer->id),
        ];

        return view('dashboard.trainer.dashboard', compact(
            'trainer',
            'todayClasses',
            'upcomingClasses',
            'recentAttendance',
            'stats'
        ));
    }

    /**
     * Show trainer's schedule
     */
    public function schedule(Request $request)
    {
        $trainer = Auth::user()->trainer;

        if (!$trainer) {
            return redirect()->route('home')->with('error', 'Trainer profile not found');
        }

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $classes = ClassInstance::with(['course', 'member'])
            ->where('trainer_id', $trainer->id)
            ->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($class) {
                return $class->start_date->format('Y-m-d');
            });

        return view('dashboard.trainer.schedule', compact('trainer', 'classes', 'month', 'year', 'startDate', 'endDate'));
    }

    /**
     * Show specific class details
     */
    public function classDetails($classId)
    {
        $trainer = Auth::user()->trainer;

        $class = ClassInstance::with(['course', 'schedule', 'member' => function ($query) {
            $query->orderBy('name');
        }])
            ->where('trainer_id', $trainer->id)
            ->findOrFail($classId);

        // Get all enrolled members for this class date
        $enrolledMembers = $class->schedule->member()
            ->wherePivot('status', 'active')
            ->wherePivot('enrolled_date', '<=', $class->start_date)
            ->where(function ($query) use ($class) {
                $query->whereNull('member_schedule.expiry_date')
                    ->orWhere('member_schedule.expiry_date', '>=', $class->start_date);
            })
            ->orderBy('name')
            ->get();

        // Mark attendance status
        $attendance = [];
        foreach ($enrolledMembers as $member) {
            $attended = $class->member->contains('id', $member->id);
            $attendance[] = [
                'member' => $member,
                'status' => $attended ? $member->pivot->attendance_status : null,
                'check_in' => $attended ? $member->pivot->check_in_time : null,
                'note' => $attended ? $member->pivot->note : null,
            ];
        }

        return view('dashboard.trainer.class-details', compact('class', 'attendance'));
    }

    /**
     * Mark attendance for a class
     */
    public function markAttendance(Request $request, $classId)
    {
        $trainer = Auth::user()->trainer;

        $class = ClassInstance::where('trainer_id', $trainer->id)->findOrFail($classId);

        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.member_id' => 'required|exists:members,id',
            'attendance.*.status' => 'nullable|in:present,absent,late',
            'attendance.*.check_in' => 'nullable|date_format:H:i',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->attendance as $data) {
                $memberId = $data['member_id'];
                $status = $data['status'] ?? null;
                $checkIn = $data['check_in'] ?? null;
                $notes = $data['notes'] ?? null;

                $exists = DB::table('class_instance_member')
                    ->where('class_instance_id', $classId)
                    ->where('member_id', $memberId)
                    ->exists();

                if ($exists) {
                    DB::table('class_instance_member')
                        ->where('class_instance_id', $classId)
                        ->where('member_id', $memberId)
                        ->update([
                            'attendance_status' => $status,
                            'check_in_time' => $checkIn,
                            'note' => $notes,
                            'updated_at' => now(),
                        ]);
                } else {
                    DB::table('class_instance_member')->insert([
                        'class_instance_id' => $classId,
                        'member_id' => $memberId,
                        'attendance_status' => $status,
                        'check_in_time' => $checkIn,
                        'note' => $notes,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Update available spots
            $class->updateAvailableSpots();

            DB::commit();

            return redirect()->route('trainer.class.details', $classId)
                ->with('success', 'Attendance marked successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error marking attendance: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show trainer's members
     */
    public function members()
    {
        $trainer = Auth::user()->trainer;

        // Get unique members who attended trainer's classes
        $members = Member::whereIn('id', function ($query) use ($trainer) {
            $query->select('member_id')
                ->from('class_instance_member')
                ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                ->where('class_instances.trainer_id', $trainer->id)
                ->distinct();
        })
            ->with(['classInstance' => function ($query) use ($trainer) {
                $query->whereHas('trainer', function ($q) use ($trainer) {
                    $q->where('trainer_id', $trainer->id);
                });
            }])
            ->paginate(15);

        // Add attendance stats for each member
        foreach ($members as $member) {
            $member->total_classes = DB::table('class_instance_member')
                ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                ->where('class_instances.trainer_id', $trainer->id)
                ->where('class_instance_member.member_id', $member->id)
                ->count();

            $member->attended_classes = DB::table('class_instance_member')
                ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                ->where('class_instances.trainer_id', $trainer->id)
                ->where('class_instance_member.member_id', $member->id)
                ->whereIn('class_instance_member.attendance_status', ['present', 'late'])
                ->count();
        }

        return view('dashboard.trainer.members', compact('trainer', 'members'));
    }

    /**
     * Show trainer's statistics
     */
    public function statistics(Request $request)
    {
        $trainer = Auth::user()->trainer;

        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Classes statistics
        $classesStats = ClassInstance::where('trainer_id', $trainer->id)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(total_spots) as total_capacity'),
                DB::raw('AVG(total_spots) as avg_capacity')
            )
            ->first();

        // Attendance statistics
        $attendanceStats = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->where('class_instances.trainer_id', $trainer->id)
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as present'),
                DB::raw('SUM(CASE WHEN attendance_status = "absent" THEN 1 ELSE 0 END) as absent'),
                DB::raw('SUM(CASE WHEN attendance_status IS NULL THEN 1 ELSE 0 END) as not_marked')
            )
            ->first();

        // Daily trend
        $dailyTrend = DB::table('class_instances')
            ->leftJoin('class_instance_member', 'class_instances.id', '=', 'class_instance_member.class_instance_id')
            ->where('class_instances.trainer_id', $trainer->id)
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'class_instances.start_date',
                DB::raw('COUNT(DISTINCT class_instances.id) as classes'),
                DB::raw('COUNT(class_instance_member.id) as attendees')
            )
            ->groupBy('class_instances.start_date')
            ->orderBy('class_instances.start_date')
            ->get();

        // Course breakdown
        $courseBreakdown = DB::table('class_instances')
            ->join('courses', 'class_instances.course_id', '=', 'courses.id')
            ->leftJoin('class_instance_member', 'class_instances.id', '=', 'class_instance_member.class_instance_id')
            ->where('class_instances.trainer_id', $trainer->id)
            ->whereBetween('class_instances.start_date', [$startDate, $endDate])
            ->select(
                'courses.name as course_name',
                DB::raw('COUNT(DISTINCT class_instances.id) as classes'),
                DB::raw('COUNT(class_instance_member.id) as total_attendees'),
                DB::raw('SUM(CASE WHEN class_instance_member.attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as present')
            )
            ->groupBy('courses.id', 'courses.name')
            ->get();

        return view('dashboard.trainer.statistics', compact(
            'trainer',
            'classesStats',
            'attendanceStats',
            'dailyTrend',
            'courseBreakdown',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Calculate trainer's overall attendance rate
     */
    private function calculateAttendanceRate($trainerId)
    {
        $total = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->where('class_instances.trainer_id', $trainerId)
            ->count();

        if ($total == 0) {
            return 0;
        }

        $present = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->where('class_instances.trainer_id', $trainerId)
            ->whereIn('class_instance_member.attendance_status', ['present', 'late'])
            ->count();

        return round(($present / $total) * 100, 2);
    }
}
