<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\ClassInstance;
use App\Models\Equipment;
use App\Models\EquipmentAssignment;
use App\Models\EquipmentMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    /**
     * Reports Dashboard
     */
    public function index()
    {
        // Get quick stats for the reports dashboard
        $stats = [
            'total_members' => Member::where('status', 'active')->count(),
            'active_trainers' => Trainer::where('status', 1)->count(),
            'total_classes_today' => ClassInstance::whereDate('start_date', today())->count(),
            'equipment_count' => Equipment::count(),
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'attendance_rate' => $this->getOverallAttendanceRate(),
        ];

        // Recent reports list
        $recentReports = [
            ['name' => 'Monthly Attendance Summary', 'date' => now()->subDays(2), 'type' => 'attendance'],
            ['name' => 'Equipment Maintenance Report', 'date' => now()->subDays(3), 'type' => 'equipment'],
            ['name' => 'Trainer Performance - Feb 2026', 'date' => now()->subDays(5), 'type' => 'trainer'],
        ];

        return view('reports.index', compact('stats', 'recentReports'));
    }

    /**
     * Member Attendance Report
     */
    public function memberAttendance(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $memberId = $request->member_id;
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        $members = Member::where('status', 'active')->orderBy('name')->get();

        if ($memberId) {
            $member = Member::with(['schedule.course', 'schedule.trainer'])->findOrFail($memberId);

            // Get attendance data for specific member
            $attendanceData = DB::table('class_instance_member')
                ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                ->join('schedules', 'class_instances.schedule_id', '=', 'schedules.id')
                ->join('courses', 'schedules.course_id', '=', 'courses.id')
                ->join('trainers', 'schedules.trainer_id', '=', 'trainers.id')
                ->where('class_instance_member.member_id', $memberId)
                ->whereBetween('class_instances.start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
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
                ->get();

            // Calculate statistics
            $stats = [
                'total_classes' => $attendanceData->count(),
                'present' => $attendanceData->whereIn('attendance_status', ['present', 'late'])->count(),
                'absent' => $attendanceData->where('attendance_status', 'absent')->count(),
                'not_marked' => $attendanceData->whereNull('attendance_status')->count(),
                'total_minutes' => $attendanceData->sum('duration_minutes'),
            ];
            $stats['attendance_rate'] = $stats['total_classes'] > 0
                ? round(($stats['present'] / $stats['total_classes']) * 100, 2)
                : 0;

            // Monthly trend data
            $monthlyTrend = DB::table('class_instance_member')
                ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                ->where('class_instance_member.member_id', $memberId)
                ->whereBetween('class_instances.start_date', [$startDate->copy()->subMonths(6)->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->select(
                    DB::raw('DATE_FORMAT(class_instances.start_date, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN class_instance_member.attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as present')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            return view('reports.member.attendance', compact(
                'member',
                'attendanceData',
                'stats',
                'monthlyTrend',
                'startDate',
                'endDate',
                'members',
                'memberId'
            ));
        }

        // Show member selection page
        return view('reports.member.select', compact('members', 'startDate', 'endDate', 'memberId'));
    }

    /**
     * Trainer Performance Report
     */
    public function trainerPerformance(Request $request)
    {
        $request->validate([
            'trainer_id' => 'nullable|exists:trainers,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $trainerId = $request->trainer_id;
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        $trainers = Trainer::where('status', 1)->orderBy('name')->get();

        if ($trainerId) {
            $trainer = Trainer::findOrFail($trainerId);

            // Get trainer's classes in date range
            $classes = ClassInstance::with(['schedule', 'course', 'member'])
                ->where('trainer_id', $trainerId)
                ->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->orderBy('start_date')
                ->get();

            // Calculate statistics
            $totalClasses = $classes->count();
            $totalMembers = 0;
            $totalAttendance = 0;
            $classAttendanceRates = [];

            foreach ($classes as $class) {
                $classMembers = $class->member->count();
                $classPresent = $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();

                $totalMembers += $classMembers;
                $totalAttendance += $classPresent;

                if ($classMembers > 0) {
                    $classAttendanceRates[] = ($classPresent / $classMembers) * 100;
                }
            }

            $stats = [
                'total_classes' => $totalClasses,
                'total_member_slots' => $totalMembers,
                'total_attendance' => $totalAttendance,
                'avg_class_size' => $totalClasses > 0 ? round($totalMembers / $totalClasses, 1) : 0,
                'avg_attendance_rate' => count($classAttendanceRates) > 0
                    ? round(array_sum($classAttendanceRates) / count($classAttendanceRates), 2)
                    : 0,
                'unique_courses' => $classes->pluck('course_id')->unique()->count(),
            ];

            // Daily class count trend
            $dailyTrend = $classes->groupBy(function ($class) {
                return $class->start_date->format('Y-m-d');
            })->map(function ($dayClasses) {
                return [
                    'date' => $dayClasses->first()->start_date,
                    'count' => $dayClasses->count(),
                    'members' => $dayClasses->sum(function ($class) {
                        return $class->member->count();
                    }),
                ];
            })->values();

            // Course breakdown
            $courseBreakdown = $classes->groupBy('course_id')->map(function ($courseClasses) {
                $course = $courseClasses->first()->course;
                $totalMembers = $courseClasses->sum(function ($class) {
                    return $class->member->count();
                });
                $totalPresent = $courseClasses->sum(function ($class) {
                    return $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();
                });

                return [
                    'course_name' => $course->name ?? 'Unknown',
                    'class_count' => $courseClasses->count(),
                    'total_members' => $totalMembers,
                    'attendance_rate' => $totalMembers > 0 ? round(($totalPresent / $totalMembers) * 100, 2) : 0,
                ];
            })->values();

            return view('reports.trainer.performance', compact(
                'trainer',
                'classes',
                'stats',
                'dailyTrend',
                'courseBreakdown',
                'startDate',
                'endDate',
                'trainers',
                'trainerId'
            ));
        }

        return view('reports.trainer.select', compact(
            'trainers',
            'startDate',
            'endDate',
            'trainerId'
        ));
    }

    /**
     * Financial Revenue Report
     */
    public function financialRevenue(Request $request)
    {
        $request->validate([
            'period' => 'nullable|in:monthly,quarterly,yearly',
            'year' => 'nullable|integer|min:2020|max:2030',
        ]);

        $period = $request->period ?? 'monthly';
        $year = $request->year ?? now()->year;

        // This is a simplified version - you'll need to integrate with your payment/membership system
        // Assuming you have a payments or memberships table

        // For demonstration, I'll create sample data structure
        $revenueData = $this->getRevenueData($period, $year);

        // Revenue by category (assuming you have course categories)
        $categoryRevenue = [
            ['category' => 'Yoga', 'revenue' => 12500, 'percentage' => 25],
            ['category' => 'Strength Training', 'revenue' => 15000, 'percentage' => 30],
            ['category' => 'Cardio', 'revenue' => 10000, 'percentage' => 20],
            ['category' => 'Pilates', 'revenue' => 7500, 'percentage' => 15],
            ['category' => 'Other', 'revenue' => 5000, 'percentage' => 10],
        ];

        // Revenue by trainer
        $trainerRevenue = Trainer::withCount(['schedules' => function ($query) use ($year) {
            $query->whereYear('created_at', $year);
        }])
            ->having('schedules_count', '>', 0)
            ->get()
            ->map(function ($trainer) {
                // This is sample calculation - adjust based on your actual revenue model
                $revenue = $trainer->schedules_count * 500; // Assume $500 per schedule
                return [
                    'name' => $trainer->name,
                    'classes' => $trainer->schedules_count,
                    'revenue' => $revenue,
                ];
            });

        $summary = [
            'total_revenue' => array_sum(array_column($categoryRevenue, 'revenue')),
            'average_monthly' => array_sum(array_column($categoryRevenue, 'revenue')) / 12,
            'growth_rate' => 12.5, // Sample growth rate
            'top_category' => 'Strength Training',
        ];

        return view('reports.financial.revenue', compact(
            'revenueData',
            'categoryRevenue',
            'trainerRevenue',
            'summary',
            'period',
            'year'
        ));
    }

    /**
     * Equipment Utilization Report
     */
    public function equipmentUtilization(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:equipment_categories,id',
            'status' => 'nullable|in:all,available,in_use,maintenance',
            'date_range' => 'nullable|in:week,month,quarter,year',
        ]);

        $categoryId = $request->category_id;
        $status = $request->status ?? 'all';
        $dateRange = $request->date_range ?? 'month';

        // Get date range
        $endDate = now();
        $startDate = match ($dateRange) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'quarter' => now()->subMonths(3),
            'year' => now()->subYear(),
            default => now()->subMonth(),
        };

        // Equipment statistics
        $equipmentStats = [
            'total' => Equipment::count(),
            'available' => Equipment::where('status', 'available')->sum('available_quantity'),
            'in_use' => Equipment::where('status', 'in_use')->count(),
            'maintenance' => Equipment::whereIn('status', ['maintenance', 'broken'])->count(),
            'total_value' => Equipment::sum('current_value'),
        ];

        // Equipment by category
        $categoryStats = DB::table('equipment')
            ->join('equipment_categories', 'equipment.category_id', '=', 'equipment_categories.id')
            ->select(
                'equipment_categories.name as category',
                DB::raw('COUNT(equipment.id) as total'),
                DB::raw('SUM(CASE WHEN equipment.status = "available" THEN 1 ELSE 0 END) as available'),
                DB::raw('SUM(equipment.current_value) as total_value')
            )
            ->groupBy('equipment_categories.id', 'equipment_categories.name')
            ->get();

        // Maintenance cost trends
        $maintenanceCosts = EquipmentMaintenance::whereBetween('maintenance_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(maintenance_date, "%Y-%m") as month'),
                DB::raw('SUM(cost) as total_cost'),
                DB::raw('COUNT(*) as maintenance_count')
            )
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Most used equipment (based on assignments)
        $mostUsed = Equipment::withCount(['assignments' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('assigned_at', [$startDate, $endDate]);
        }])
            ->having('assignments_count', '>', 0)
            ->orderBy('assignments_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($equipment) {
                return [
                    'name' => $equipment->name,
                    'code' => $equipment->code,
                    'usage_count' => $equipment->assignments_count,
                    'category' => $equipment->category->name ?? 'N/A',
                ];
            });

        // Utilization rate calculation
        $utilizationRate = $equipmentStats['total'] > 0
            ? round(($equipmentStats['in_use'] / $equipmentStats['total']) * 100, 2)
            : 0;

        $categories = DB::table('equipment_categories')->get();

        return view('reports.equipment.utilization', compact(
            'equipmentStats',
            'categoryStats',
            'maintenanceCosts',
            'mostUsed',
            'utilizationRate',
            'categories',
            'categoryId',
            'status',
            'dateRange',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Daily Operations Report
     */
    public function dailyOperations(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : today();

        // Get all classes for the selected date
        $classes = ClassInstance::with(['schedule', 'trainer', 'course', 'member'])
            ->whereDate('start_date', $date)
            ->orderBy('start_time')
            ->get();

        // Calculate statistics
        $stats = [
            'total_classes' => $classes->count(),
            'total_trainers' => $classes->pluck('trainer_id')->unique()->count(),
            'total_expected' => $classes->sum(function ($class) {
                return $class->member->count();
            }),
            'total_present' => $classes->sum(function ($class) {
                return $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();
            }),
            'total_absent' => $classes->sum(function ($class) {
                return $class->member->where('pivot.attendance_status', 'absent')->count();
            }),
        ];

        $stats['attendance_rate'] = $stats['total_expected'] > 0
            ? round(($stats['total_present'] / $stats['total_expected']) * 100, 2)
            : 0;

        // Occupancy by class
        $occupancyData = $classes->map(function ($class) {
            $capacity = $class->total_spots;
            $enrolled = $class->member->count();
            $present = $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();

            return [
                'time' => Carbon::parse($class->start_time)->format('g:i A'),
                'course' => $class->course->name ?? 'N/A',
                'trainer' => $class->trainer->name ?? 'N/A',
                'capacity' => $capacity,
                'enrolled' => $enrolled,
                'present' => $present,
                'occupancy_rate' => $capacity > 0 ? round(($enrolled / $capacity) * 100, 2) : 0,
                'attendance_rate' => $enrolled > 0 ? round(($present / $enrolled) * 100, 2) : 0,
            ];
        });

        // Equipment in use today
        $equipmentInUse = EquipmentAssignment::with(['equipment', 'assignable'])
            ->whereDate('assigned_at', $date)
            ->where('status', 'assigned')
            ->get();

        return view('reports.operations.daily', compact(
            'date',
            'classes',
            'stats',
            'occupancyData',
            'equipmentInUse'
        ));
    }

    /**
     * Export Report (PDF/Excel)
     */
    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:member,trainer,financial,equipment,operations',
            'format' => 'required|in:pdf,excel,csv',
            'data' => 'required|json',
        ]);

        $type = $request->type;
        $format = $request->format;
        $data = json_decode($request->data, true);

        $filename = $type . '_report_' . now()->format('Y-m-d_His');

        switch ($format) {
            case 'pdf':
                return $this->exportPDF($type, $data, $filename);
            case 'excel':
                return $this->exportExcel($type, $data, $filename);
            case 'csv':
                return $this->exportCSV($type, $data, $filename);
        }
    }

    /**
     * Get Monthly Revenue Data
     */
    private function getMonthlyRevenue()
    {
        // This should be replaced with actual revenue data from your database
        // For now, return sample data
        return [
            'total' => 50000,
            'growth' => 15,
        ];
    }

    /**
     * Get Overall Attendance Rate
     */
    private function getOverallAttendanceRate()
    {
        $totalMarked = DB::table('class_instance_member')
            ->whereNotNull('attendance_status')
            ->count();

        $totalPresent = DB::table('class_instance_member')
            ->whereIn('attendance_status', ['present', 'late'])
            ->count();

        return $totalMarked > 0 ? round(($totalPresent / $totalMarked) * 100, 2) : 0;
    }

    /**
     * Get Revenue Data for Charts
     */
    private function getRevenueData($period, $year)
    {
        // This should be replaced with actual revenue data
        // Sample data structure
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        if ($period == 'monthly') {
            return collect($months)->map(function ($month, $index) {
                return [
                    'label' => $month,
                    'revenue' => rand(8000, 15000),
                    'memberships' => rand(40, 80),
                    'classes' => rand(20, 40),
                ];
            });
        } elseif ($period == 'quarterly') {
            return collect([
                ['label' => 'Q1', 'revenue' => rand(25000, 35000)],
                ['label' => 'Q2', 'revenue' => rand(30000, 40000)],
                ['label' => 'Q3', 'revenue' => rand(28000, 38000)],
                ['label' => 'Q4', 'revenue' => rand(32000, 42000)],
            ]);
        } else {
            return collect([
                ['label' => $year - 2, 'revenue' => rand(120000, 150000)],
                ['label' => $year - 1, 'revenue' => rand(140000, 170000)],
                ['label' => $year, 'revenue' => rand(160000, 190000)],
            ]);
        }
    }

    /**
     * Export as PDF
     */
    private function exportPDF($type, $data, $filename)
    {
        // You'll need to install a PDF package like dompdf
        // $pdf = PDF::loadView("reports.exports.{$type}", compact('data'));
        // return $pdf->download("{$filename}.pdf");

        // For now, return a JSON response
        return response()->json(['message' => 'PDF export would be generated here']);
    }

    /**
     * Export as Excel
     */
    private function exportExcel($type, $data, $filename)
    {
        // You can use Laravel Excel package for this
        return response()->json(['message' => 'Excel export would be generated here']);
    }

    /**
     * Export as CSV
     */
    private function exportCSV($type, $data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}.csv",
        ];

        $callback = function () use ($data, $type) {
            $file = fopen('php://output', 'w');

            // Add headers based on report type
            if ($type == 'member') {
                fputcsv($file, ['Date', 'Course', 'Trainer', 'Status', 'Check In', 'Check Out', 'Duration']);
                foreach ($data['attendance'] ?? [] as $row) {
                    fputcsv($file, [
                        $row['date'] ?? '',
                        $row['course'] ?? '',
                        $row['trainer'] ?? '',
                        $row['status'] ?? '',
                        $row['check_in'] ?? '',
                        $row['check_out'] ?? '',
                        $row['duration'] ?? '',
                    ]);
                }
            }
            // Add other report types here...

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Analytics - Member Retention
     */
    public function memberRetention(Request $request)
    {
        $request->validate([
            'period' => 'nullable|in:monthly,quarterly,yearly',
        ]);

        $period = $request->period ?? 'monthly';

        // Get member retention data
        $retentionData = $this->calculateRetentionRates($period);

        return view('reports.analytics.retention', compact('retentionData', 'period'));
    }

    /**
     * Calculate Retention Rates
     */
    private function calculateRetentionRates($period)
    {
        // This should be based on your actual member data
        // Sample calculation
        $data = [];
        $now = now();

        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $cohort = $date->format('M Y');

            // Sample retention rates for demonstration
            $data[] = [
                'cohort' => $cohort,
                'month1' => rand(85, 95),
                'month2' => rand(75, 85),
                'month3' => rand(65, 75),
                'month4' => rand(55, 65),
                'month5' => rand(45, 55),
                'month6' => rand(40, 50),
            ];
        }

        return $data;
    }

    /**
     * Analytics - Class Popularity
     */
    public function classPopularity(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        // Get all classes first - store in $classes variable
        $classes = ClassInstance::with(['course', 'trainer', 'members'])
            ->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        // Get class popularity data
        $popularityData = $classes  // Now using the $classes variable
            ->groupBy('course_id')
            ->map(function ($classes) {
                $course = $classes->first()->course;
                $totalSpots = $classes->sum('total_spots');
                $totalEnrolled = $classes->sum(function ($class) {
                    return $class->members->count();
                });

                return [
                    'course_name' => $course->name ?? 'Unknown',
                    'total_classes' => $classes->count(),
                    'total_spots' => $totalSpots,
                    'total_enrolled' => $totalEnrolled,
                    'occupancy_rate' => $totalSpots > 0 ? round(($totalEnrolled / $totalSpots) * 100, 2) : 0,
                    'avg_class_size' => $classes->count() > 0 ? round($totalEnrolled / $classes->count(), 1) : 0,
                ];
            })
            ->sortByDesc('occupancy_rate')
            ->values();

        // Popular time slots - now using the same $classes variable
        $timeSlots = $classes->groupBy(function ($class) {
            return Carbon::parse($class->start_time)->format('H');
        })->map(function ($classes, $hour) {
            $totalEnrolled = $classes->sum(function ($class) {
                return $class->members->count();
            });
            return [
                'time' => Carbon::createFromFormat('H', $hour)->format('g A'),
                'classes' => $classes->count(),
                'total_enrolled' => $totalEnrolled,
                'avg_per_class' => $classes->count() > 0 ? round($totalEnrolled / $classes->count(), 1) : 0,
            ];
        })->sortKeys();

        return view('reports.analytics.popularity', compact(
            'popularityData',
            'timeSlots',
            'startDate',
            'endDate'
        ));
    }
}
