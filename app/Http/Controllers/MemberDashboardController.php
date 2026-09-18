<?php
// app/Http/Controllers/MemberDashboardController.php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\ClassInstance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    /**
     * Show member dashboard
     */
    public function memberDashboard()
    {
        // Get the logged-in member
        $user = Auth::user()->code;
        $member = Member::where('code', $user)->first();

        if (!$member) {
            return 'no';
        }

        // Get member's active schedules/enrollments
        $activeEnrollments = $member->schedule()
            ->wherePivot('status', 'active')
            ->wherePivot('enrolled_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('member_schedule.expiry_date')
                    ->orWhere('member_schedule.expiry_date', '>=', now());
            })
            ->with(['course', 'trainer'])
            ->get();

        // Get upcoming classes (next 7 days)
        $upcomingClasses = ClassInstance::with(['schedule', 'course', 'trainer'])
            ->whereHas('member', function ($query) use ($member) {
                $query->where('member_id', $member->id);
            })
            ->whereBetween('start_date', [now(), now()->addDays(7)])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->map(function ($class) {
                $class->formatted_date = Carbon::parse($class->start_date)->format('l, M d, Y');
                $class->formatted_time = Carbon::parse($class->start_time)->format('g:i A');
                return $class;
            });

        // Get recent attendance (last 30 days)
        $recentAttendance = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('courses', 'class_instances.course_id', '=', 'courses.id')
            ->join('trainers', 'class_instances.trainer_id', '=', 'trainers.id')
            ->where('class_instance_member.member_id', $member->id)
            ->where('class_instances.start_date', '>=', now()->subDays(30))
            ->orderBy('class_instances.start_date', 'desc')
            ->limit(10)
            ->select(
                'class_instances.*',
                'class_instance_member.attendance_status',
                'class_instance_member.check_in_time',
                'class_instance_member.check_out_time',
                'courses.name as course_name',
                'trainers.name as trainer_name'
            )
            ->get();

        // Calculate attendance statistics
        $totalClasses = DB::table('class_instance_member')
            ->where('member_id', $member->id)
            ->count();

        $presentClasses = DB::table('class_instance_member')
            ->where('member_id', $member->id)
            ->whereIn('attendance_status', ['present', 'late'])
            ->count();

        $attendanceRate = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 2) : 0;

        // Get this week's attendance
        $weekAttendance = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->where('class_instance_member.member_id', $member->id)
            ->whereBetween('class_instances.start_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Get monthly trend (last 6 months)
        $monthlyTrend = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->where('class_instance_member.member_id', $member->id)
            ->where('class_instances.start_date', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(class_instances.start_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN class_instance_member.attendance_status IN ("present", "late") THEN 1 ELSE 0 END) as present')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get membership info
        $membership = $member->schedule()
            ->wherePivot('status', 'active')
            ->withPivot(['enrolled_date', 'expiry_date', 'plan_id'])
            ->first();

        $plan = $membership ? $membership->pivot->plan_id : null;
        $planDetails = $plan ? \App\Models\Plan::find($plan) : null;

        $daysUntilExpiry = $membership && $membership->pivot->expiry_date
            ? Carbon::now()->diffInDays(Carbon::parse($membership->pivot->expiry_date), false)
            : null;

        // Get favorite class type
        $favoriteClass = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('courses', 'class_instances.course_id', '=', 'courses.id')
            ->where('class_instance_member.member_id', $member->id)
            ->select('courses.name', DB::raw('COUNT(*) as count'))
            ->groupBy('courses.id', 'courses.name')
            ->orderBy('count', 'desc')
            ->first();

        // Get next class
        $nextClass = ClassInstance::with(['course', 'trainer', 'schedule'])
            ->whereHas('member', function ($query) use ($member) {
                $query->where('member_id', $member->id);
            })
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->first();

        return view('dashboard.member.dashboard', compact(
            'member',
            'activeEnrollments',
            'upcomingClasses',
            'recentAttendance',
            'totalClasses',
            'presentClasses',
            'attendanceRate',
            'weekAttendance',
            'monthlyTrend',
            'membership',
            'planDetails',
            'daysUntilExpiry',
            'favoriteClass',
            'nextClass'
        ));
    }

    /**
     * Show member profile
     */
    public function profile()
    {
        $user = Auth::user();
        $member = Member::where('code', $user->code)->first();

        return view('dashboard.member.profile', compact('member', 'user'));
    }

    /**
     * Update member profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $member = Member::where('code', $user->code)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Update user
        $userData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'adress' => $request->address,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('admin/uploads'), $filename);
            $userData['photo'] = $filename;
        }

        $user->update($userData);

        // Update member if exists
        if ($member) {
            $member->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        return redirect()->route('member.profile')
            ->with('success', 'Profile updated successfully');
    }

    /**
     * Show member attendance history
     */
    public function attendance()
    {
        $user = Auth::user();
        $member = Member::where('code', $user->code)->first();

        $attendance = DB::table('class_instance_member')
            ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
            ->join('courses', 'class_instances.course_id', '=', 'courses.id')
            ->join('trainers', 'class_instances.trainer_id', '=', 'trainers.id')
            ->where('class_instance_member.member_id', $member->id)
            ->orderBy('class_instances.start_date', 'desc')
            ->select(
                'class_instances.start_date',
                'class_instances.start_time',
                'class_instances.end_time',
                'class_instance_member.attendance_status',
                'class_instance_member.check_in_time',
                'class_instance_member.check_out_time',
                'class_instance_member.duration_minutes',
                'courses.name as course_name',
                'trainers.name as trainer_name'
            )
            ->paginate(15);

        return view('dashboard.member.attendance', compact('member', 'attendance'));
    }

    /**
     * Show member schedule
     */
    public function schedule()
    {
        $user = Auth::user();
        $member = Member::where('code', $user->code)->first();

        $schedules = $member->schedule()
            ->with(['course', 'trainer'])
            ->wherePivot('status', 'active')
            ->get();

        $classInstances = ClassInstance::with(['course', 'trainer', 'schedule'])
            ->whereHas('member', function ($query) use ($member) {
                $query->where('member_id', $member->id);
            })
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($class) {
                return Carbon::parse($class->start_date)->format('Y-m-d');
            });

        return view('dashboard.member.schedule', compact('member', 'schedules', 'classInstances'));
    }

    /**
     * Check-in to a class (self check-in)
     */
    public function checkIn($classInstanceId)
    {
        $user = Auth::user();
        $member = Member::where('email', $user->email)->first();

        $class = ClassInstance::findOrFail($classInstanceId);

        // Check if member is enrolled
        $isEnrolled = DB::table('class_instance_member')
            ->where('class_instance_id', $classInstanceId)
            ->where('member_id', $member->id)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->back()->with('error', 'You are not enrolled in this class');
        }

        // Check if already checked in
        $alreadyChecked = DB::table('class_instance_member')
            ->where('class_instance_id', $classInstanceId)
            ->where('member_id', $member->id)
            ->whereNotNull('check_in_time')
            ->exists();

        if ($alreadyChecked) {
            return redirect()->back()->with('error', 'You have already checked in');
        }

        // Check if class is today
        if (Carbon::parse($class->start_date)->format('Y-m-d') != now()->format('Y-m-d')) {
            return redirect()->back()->with('error', 'You can only check in on the day of the class');
        }

        // Check if within check-in window (15 min before to 15 min after start)
        $classStart = Carbon::parse($class->start_date . ' ' . $class->start_time);
        $now = now();
        $checkInWindowStart = $classStart->copy()->subMinutes(15);
        $checkInWindowEnd = $classStart->copy()->addMinutes(15);

        if ($now->lt($checkInWindowStart) || $now->gt($checkInWindowEnd)) {
            return redirect()->back()->with('error', 'Check-in is only allowed 15 minutes before to 15 minutes after class start');
        }

        // Determine status (on time or late)
        $status = $now->lte($classStart) ? 'present' : 'late';

        // Update attendance
        DB::table('class_instance_member')
            ->where('class_instance_id', $classInstanceId)
            ->where('member_id', $member->id)
            ->update([
                'attendance_status' => $status,
                'check_in_time' => $now->format('H:i:s'),
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Checked in successfully!');
    }
}
