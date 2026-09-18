<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMemberToScheduleRequest;
use App\Http\Requests\ScheduleRequest;
use App\Models\ClassInstance;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Schedule;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{

    public function member_schedule($courseId, $trainerId = null, $memberID = null)
    {
        // Always get the course data first
        $course_data = Course::where('id', $courseId)->where('status', 1)->first();

        if (!$course_data) {
            abort(404, 'Course not found');
        }

        $courseSchedules = Schedule::with(['trainer', 'member', 'classInstances'])
            ->where('course_id', $courseId)
            ->where('status', 1) // Only active schedules
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        if ($memberID) {
            // When member ID is provided, get trainers ASSIGNED TO THIS COURSE only
            $trainer_data = $course_data->trainers()  // This gets only trainers for this course
                ->orderBy('id', 'DESC')
                ->get();

            $member_data = Member::where('id', $memberID)->where('status', 'active')->first();
        } elseif ($trainerId) {
            // When trainer ID is provided, verify this trainer is assigned to the course
            $trainer_data = Trainer::where('id', $trainerId)
                ->whereHas('courses', function ($query) use ($courseId) {
                    $query->where('course_id', $courseId);
                })
                ->where('status', 1)
                ->first();

            // If trainer is not assigned to this course, show error or redirect
            if (!$trainer_data) {
                // Option 1: Redirect back with error
                return redirect()->back()->with('error', 'This trainer is not assigned to the selected course');
            }

            $member_data = Member::orderBy('id', 'DESC')->where('status', 'active')->get();
            $memberID = null;
        } else {
            // No IDs provided, get trainers ASSIGNED TO THIS COURSE only
            $trainer_data = $course_data->trainers()
                ->orderBy('id', 'DESC')
                ->get();

            $member_data = Member::orderBy('id', 'DESC')->where('status', 'active')->get();
        }

        return view('schedule.course', [
            'trainer_data' => $trainer_data,
            'course_data' => $course_data,
            'member_data' => $member_data,
            'trainerId' => $trainerId,
            'memberID' => $memberID,
            'courseSchedules' => $courseSchedules,
        ]);
    }


    /*  public function member_schedule($courseId, $trainerId = null, $memberID = null)
    {

        // Always get the course data first
        $course_data = Course::where('id', $courseId)->where('status', 1)->first();

        $courseSchedules = Schedule::with(['trainer', 'member', 'classInstances'])
            ->where('course_id', $courseId)
            ->where('status', 1) // Only active schedules
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();


        if ($memberID) {
            // When member ID is provided (from member route), get that specific member only
            // and get all trainers
            $trainer_data = Trainer::orderBy('id', 'DESC')->get();
            $member_data = Member::where('id', $memberID)->where('status', 'active')->first();
        } elseif ($trainerId) {
            // When trainer ID is provided (from trainer route), get that specific trainer only
            // and get all members
            $trainer_data = Trainer::where('id', $trainerId)->where('status', 1)->first();
            $member_data = Member::orderBy('id', 'DESC')->where('status', 'active')->get();

            // IMPORTANT: When coming from trainer route, we want to show all members but NOT preselect any
            // The memberID should remain null so the user can select a member
            $memberID = null;
        } else {
            // No IDs provided, get all trainers and all members
            $trainer_data = Trainer::orderBy('id', 'DESC')->get();
            $member_data = Member::orderBy('id', 'DESC')->where('status', 'active')->get();
        }


        return view('schedule.course', [
            'trainer_data' => $trainer_data,
            'course_data' => $course_data,
            'member_data' => $member_data,
            'trainerId' => $trainerId,
            'memberID' => $memberID,
            'courseSchedules' => $courseSchedules,
        ]);
    } */

    /* public function member_schedule($courseId, $trainerId = null, $memberId = null)
    {
        if ($trainerId) {
            return "Course: $courseId, Trainer: $trainerId";
        } elseif ($memberId) {
            return "Course: $courseId, Member: $memberId";
        }
        return "Course: $courseId only";
    } */


    public function create(Request $request)
    {
        // Get all parameters from the URL
        $courseId = $request->query('course_id');
        $trainerId = $request->query('trainer_id');
        $memberId = $request->query('member_id');

        // Get time parameters
        $day_of_week = $request->query('day');
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');
        $selectedDate = $request->query('date');

        // Get the full data for the view
        $course = Course::find($courseId);
        $trainer = Trainer::find($trainerId);
        $member = Member::find($memberId);


        // Get existing schedules for this member at this time slot
        /*  $existingSchedules = Schedule::with(['trainer', 'course', 'member'])
            ->whereHas('member', function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            })
            ->where('trainer_id', $trainerId)
            ->where('course_id', $courseId)
            ->get(); */
        $existingSchedules = Schedule::with(['trainer', 'course', 'member'])
            ->whereHas('member', function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            })
            ->get();

        // Pass all data to the view
        return view('class_instance.create_schedule', compact(
            'course',
            'trainer',
            'member',
            'existingSchedules',
        ));
    }


    public function createClassInstance(Request $request)
    {
        // Get the parameters from the URL
        $courseId = $request->query('course_id');
        $trainerId = $request->query('trainer_id');
        $memberId = $request->query('member_id');


        $startTime = date('g:i A', strtotime($request->start_time));
        $endTime = date('g:i A', strtotime($request->end_time));
        $selectedDate = date('F j, Y', strtotime($request->date));
        $selectedDay = ucfirst($request->day);

        // Get the full data for the view
        $course = Course::find($courseId);
        $trainer = Trainer::find($trainerId);
        $member = Member::find($memberId);

        /* return $course . 'ffff' . $trainer . 'fdgdgfg' . $member; */


        return view(
            'class_instance.create_instance',
            [
                'course' => $course,
                'trainer' => $trainer,
                'member' => $member,
                'selectedDay' => $selectedDay,
                'selectedDate' => $selectedDate,
                'startTime' => $startTime,
                'endTime' => $endTime
            ]
        );
    }

    public function store(ScheduleRequest $request)
    {

        try {
            // Convert time from '8:00 AM' to '08:00:00'
            $start_time = Carbon::createFromFormat('g:i A', $request['start_time'])->format('H:i:s');
            $end_time = Carbon::createFromFormat('g:i A', $request['end_time'])->format('H:i:s');

            /*  // Or if end_time might be in different format, handle accordingly
            if (str_contains($request['end_time'], 'AM') || str_contains($request['end_time'], 'PM')) {
                $end_time = Carbon::createFromFormat('g:i A', $request['end_time'])->format('H:i:s');
            } else {
                $end_time = $request['end_time']; // Keep as is if already in correct format
            } */

            // Get the actual values (not arrays)
            $member_id = $request['member_id']; // This is the member you're assigning
            $trainer_id = $request['trainer_id'];
            $course_id = $request['course_id'];
            $day_of_week = $request['day_of_week'];

            // Check if member already has a class at this time
            // Since it's many-to-many, we need to check through the pivot table
            $check_if_not_free = Schedule::whereHas('member', function ($query) use ($member_id) {
                $query->where('member_id', $member_id);
            })
                ->where([
                    'trainer_id' => $trainer_id,
                    'course_id' => $course_id,
                    'day_of_week' => $day_of_week,
                    'start_time' => $start_time
                ])->first();

            if ($check_if_not_free) {
                return redirect()->back()->with(['error' => 'Member has class at this time, please select another time']);
            }

            // Create the schedule WITHOUT member_id (since it's many-to-many)
            $schedule = Schedule::create([
                'trainer_id' => $trainer_id,
                'course_id' => $course_id,
                'plan_id' => 2,
                'day_of_week' => $day_of_week,
                'schedule_date' => now()->format('Y-m-d'),
                'start_time' => $start_time,
                'end_time' => $end_time,
                'recurrence_type' => $request['recurrence_type'],
                'recurrence_start_date' => $request['recurrence_start_date'],
                'recurrence_end_date' => $request['recurrence_end_date'],
                'status' => $request->has('is_active'),
                'is_group' => $request->has('is_group_schedule'),
                'note' => $request['notes'] ?? null,
                'added_by' => Auth::id(),
            ]);

            /* // Attach the member to the schedule through the pivot table
            $schedule->member()->attach($member_id); */

            /* instead of that we will add some cols to member_scchedule which is represented by the function schedule->member()
            so hat we can make this table useful later in our work specially in showing the info of current classes of each member */
            /* $schedule->member()->attach($member_id, [
                'enrolled_date' => $request['recurrence_start_date'], // When they start
                'expiry_date' => $request['recurrence_end_date'],     // When they end (if any)
                'status' => 'active',
                'plan_id' => $request['plan_id'] ?? 1,
                'added_by' => Auth::id(),
            ]); */

            /* instead of that we will add some cols to member_scchedule which is represented by the function schedule->member()
            so hat we can make this table useful later in our work specially in showing the info of current classes of each member */
            // update for payment 
            $CoursePrice = Course::find($request['course_id'] ?? 1)->price;
            $schedule->member()->attach($member_id, [
                'enrolled_date' => $request['recurrence_start_date'],
                'expiry_date' => $request['recurrence_end_date'],
                'status' => 'active',
                'plan_id' => $request['plan_id'] ?? 1,
                'added_by' => Auth::id(),
                'total_amount' => $CoursePrice,
                'amount_paid' => 0,
                'amount_due' => $CoursePrice,
                'course_id' => $course_id,
            ]);

            // Parse dates
            try {
                $startDate = Carbon::parse($request['recurrence_start_date']);

                // If recurrence_end_date is null or empty, create only ONE instance
                if (empty($request['recurrence_end_date']) || $request['recurrence_type'] == 'none') {
                    $endDate = clone $startDate; // Same day - only one instance
                } else {
                    $endDate = Carbon::parse($request['recurrence_end_date']);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => 'Invalid date format']);
            }

            // Parse dates
            /* $startDate = Carbon::parse($request['recurrence_start_date']);
            $endDate = $request['recurrence_end_date']
                ? Carbon::parse($request['recurrence_end_date'])
                : Carbon::parse($request['recurrence_start_date'])->addYear(); // Default 1 year
 */


            $recurrenceType = $request['recurrence_type'];
            $total_spots = $request->has('is_group_schedule') ? $request['avaliable_spots'] : 1;

            $currentDate = clone $startDate;
            $maxIterations = 100;
            $iteration = 0;

            while ($currentDate->lte($endDate) && $iteration < $maxIterations) {
                $iteration++;

                // Get all active members who should attend this specific date
                $activeMembers = $schedule->member()
                    ->wherePivot('status', 'active')
                    ->wherePivot('enrolled_date', '<=', $currentDate->format('Y-m-d'))
                    ->where(function ($query) use ($currentDate) {
                        $query->whereNull('member_schedule.expiry_date')
                            ->orWhere('member_schedule.expiry_date', '>=', $currentDate->format('Y-m-d'));
                    })
                    ->get();

                $currentAttendeeCount = $activeMembers->count();


                // Create class instance for each recurrence date
                $classInstance = ClassInstance::create([
                    'schedule_id' => $schedule->id, // NOW we have the schedule ID
                    'trainer_id' => $trainer_id,
                    'course_id' => $course_id,
                    'day_of_week' => strtolower($currentDate->format('l')),
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' =>  $currentDate->format('Y-m-d'),
                    'end_date' =>  $currentDate->format('Y-m-d'),
                    'status' => 'scheduled',
                    'is_group' => $request->has('is_group_schedule'),
                    'added_by' => Auth::id(),
                    'total_spots' => $total_spots,
                    'available_spots' => $total_spots - $currentAttendeeCount, // This will be total_spots - 1
                ]);




                /* $classInstance->member()->attach($member_id); */
                /* as we did before in the pivot table of member and schedule , we add more cols to use them 
                we will do the same in pivot table of classInsance and member */
                foreach ($activeMembers as $member) {
                    $classInstance->member()->attach($member->id, [
                        'attendance_status' => null,
                        'note' => null
                    ]);
                }

                // Move to next date based on recurrence type
                switch ($recurrenceType) {
                    case 'daily':
                        $currentDate->addDay();
                        break;
                    case 'weekly':
                        $currentDate->addWeek();
                        break;
                    case 'biweekly':
                        $currentDate->addWeeks(2);
                        break;
                    case 'monthly':
                        $currentDate->addMonth();
                        break;
                    default:
                        $currentDate = $endDate->copy()->addDay();
                }
            }

            if ($request->ajax() || $request->wantsJson()) {

                return response()->json([
                    'success' => true,
                    'message' => 'Schedule created successfully!',
                    'redirect_url' => route('classInstance.createSchedule', [
                        'course_id' => $course_id,
                        'trainer_id' => $trainer_id,
                        'member_id' => $member_id,

                    ]),
                ]);
            }
        } catch (\Exception $ex) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating schedule: ' . $ex->getMessage()
                ], 500);
            }
        }
    }

    public function showToAdd($scheduleId)
    {
        // Get the schedule with all necessary relationships
        $schedule = Schedule::with([
            'trainer',
            'course',
            'member' => function ($query) {
                $query->wherePivot('status', 'active')
                    ->orderBy('member_schedule.enrolled_date', 'desc');
            }
        ])->findOrFail($scheduleId);

        // Get all active members (excluding those already in this schedule)
        $existingMemberIds = $schedule->member->pluck('id')->toArray();

        $availableMembers = Member::where('status', 'active')
            ->whereNotIn('id', $existingMemberIds)
            ->orderBy('name')
            ->get();

        // Get available plans (assuming you have a Plan model)
        $plans = Plan::where('is_active', 1)->get();

        // Calculate statistics
        $totalSpots = $schedule->is_group ? 4 : 1;
        $currentMembers = $schedule->member->count();
        $availableSpots = $totalSpots - $currentMembers;

        return view('class_instance.add_member', compact(
            'schedule',
            'availableMembers',
            'plans',
            'totalSpots',
            'currentMembers',
            'availableSpots'
        ));
    }

    /*  public function addMemberToExistingSchedule(Request $request, $scheduleId)
    {
        try {
            $schedule = Schedule::findOrFail($scheduleId);
            $member_id = $request->member_id;
            $enrolled_date = $request->enrolled_date ?? now()->format('Y-m-d');
            $expiry_date = $request->expiry_date ?? $schedule->recurrence_end_date;

            // Check if member is already enrolled
            $existing = DB::table('member_schedule')
                ->where('schedule_id', $scheduleId)
                ->where('member_id', $member_id)
                ->where('status', 'active')
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member already enrolled in this schedule'
                ], 400);
            }

            // Check if there's space in future classes
            $futureInstances = ClassInstance::where('schedule_id', $scheduleId)
                ->where('date', '>=', $enrolled_date)
                ->get();

            $hasSpace = true;
            foreach ($futureInstances as $instance) {
                if ($instance->available_spots <= 0) {
                    $hasSpace = false;
                    break;
                }
            }

            if (!$hasSpace && $schedule->is_group) {
                return response()->json([
                    'success' => false,
                    'message' => 'No available spots in future classes'
                ], 400);
            }

            // Add to member_schedule pivot with enrollment details
            $schedule->member()->attach($member_id, [
                'enrolled_date' => $enrolled_date,
                'expiry_date' => $expiry_date,
                'status' => 'active',
                'added_by' => Auth::id(),
            ]);

            // Add to all future class instances
            foreach ($futureInstances as $instance) {
                $instance->attendees()->attach($member_id, [
                    'attendance_status' => null,
                    'check_in_time' => null,
                    'notes' => 'Added on ' . now()->format('Y-m-d')
                ]);

                // Update available spots
                $instance->updateAvailableSpots();
            }

            return response()->json([
                'success' => true,
                'message' => 'Member added to schedule successfully',
                'data' => [
                    'member_id' => $member_id,
                    'enrolled_date' => $enrolled_date,
                    'future_classes' => $futureInstances->count()
                ]
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding member: ' . $ex->getMessage()
            ], 500);
        }
    } */

    // this function does not work with the system
    public function addMemberToSchedule(AddMemberToScheduleRequest $request, $scheduleId)
    {
        try {
            $schedule = Schedule::findOrFail($scheduleId);
            $member_id = $request->member_id;
            $plan_id = $request->plan_id;
            $enrolled_date = $request->enrolled_date ?? now()->format('Y-m-d');
            $expiry_date = $request->expiry_date;

            // update expire date of schedule
            if ($schedule->recurrence_end_date < $expiry_date) {

                $update_schedule['recurrence_end_date'] = $expiry_date;
                $update_schedule['updated_by'] = Auth::id();
                $update_schedule['updated_at'] = date("Y-m-d H:i:s");
                $schedule->update($update_schedule);
            }

            // Check if member is already enrolled
            $existing = DB::table('member_schedule')
                ->where('schedule_id', $scheduleId)
                ->where('member_id', $member_id)
                ->where('status', 'active')
                ->first();

            if ($existing) {
                return redirect()->back()
                    ->with('error', 'Member is already enrolled in this schedule')
                    ->withInput();
            }

            // Check available spots
            $currentMembers = $schedule->member()->wherePivot('status', 'active')->count();
            $totalSpots = $schedule->is_group ? 4 : 1;

            if ($currentMembers >= $totalSpots) {
                return redirect()->back()
                    ->with('error', 'This schedule is full. No available spots.')
                    ->withInput();
            }

            // Get all future class instances
            $futureInstances = ClassInstance::where('schedule_id', $scheduleId)
                ->where('end_date', '>=', $enrolled_date)
                ->where('status', 'scheduled')
                ->get();

            // Check if any future instance is full
            foreach ($futureInstances as $instance) {
                if ($instance->available_spots <= 0) {
                    return redirect()->back()
                        ->with('error', "Cannot add member. Class on {$instance->date->format('Y-m-d')} is full.")
                        ->withInput();
                }
            }

            // Add to member_schedule pivot with enrollment details
            $schedule->member()->attach($member_id, [
                'plan_id' => $plan_id,
                'enrolled_date' => $enrolled_date,
                'expiry_date' => $expiry_date,
                'status' => 'active',
                'added_by' => Auth::id(),
                'created_at' => now(),
                /* 'updated_at' => now(), */
            ]);

            // Add to all future class instances
            foreach ($futureInstances as $instance) {
                $instance->member()->attach($member_id, [
                    'attendance_status' => null,
                    'check_in_time' => null,
                    'note' => 'Added on ' . now()->format('Y-m-d'),
                    'created_at' => now(),
                    /* 'updated_at' => now(), */
                ]);

                // Update available spots
                $instance->decrement('available_spots');
            }

            return redirect()->route('classInstance.showToAdd', $scheduleId)
                ->with('success', 'Member added to schedule successfully!');
        } catch (\Exception $ex) {
            Log::error('Error adding member to schedule: ' . $ex->getMessage());

            return redirect()->back()
                ->with('error', 'Error adding member: ' . $ex->getMessage())
                ->withInput();
        }
    }

    public function addMemberToExistingSchedule(AddMemberToScheduleRequest $request, $scheduleId)
    {
        try {
            $schedule = Schedule::findOrFail($scheduleId);
            $member_id = $request->member_id;
            $plan_id = $request->plan_id;
            $enrolled_date = $request->enrolled_date ?? now()->format('Y-m-d');
            $expiry_date = $request->expiry_date;

            // Parse dates for comparison
            $enrolledDateObj = Carbon::parse($enrolled_date);
            $expiryDateObj = $expiry_date ? Carbon::parse($expiry_date) : null;
            $scheduleEndDate = $schedule->recurrence_end_date ? Carbon::parse($schedule->recurrence_end_date) : null;

            // Check if member is already enrolled
            $existing = DB::table('member_schedule')
                ->where('schedule_id', $scheduleId)
                ->where('member_id', $member_id)
                ->where('status', 'active')
                ->first();

            if ($existing) {
                return redirect()->back()
                    ->with('error', 'Member is already enrolled in this schedule')
                    ->withInput();
            }

            // Check available spots
            $currentMembers = $schedule->member()->wherePivot('status', 'active')->count();
            $totalSpots = $schedule->is_group ? 4 : 1;

            if ($currentMembers >= $totalSpots) {
                return redirect()->back()
                    ->with('error', 'This schedule is full. No available spots.')
                    ->withInput();
            }

            // FIRST: Add to member_schedule pivot with enrollment details
            $schedule->member()->attach($member_id, [
                'course_id' => $schedule->course_id,
                'plan_id' => $plan_id,
                'enrolled_date' => $enrolled_date,
                'expiry_date' => $expiry_date,
                'status' => 'active',
                'added_by' => Auth::id(),
                'created_at' => now(),
            ]);

            // SECOND: EXTEND SCHEDULE IF NEEDED AND CREATE MISSING INSTANCES
            $needToExtend = false;
            if ($expiryDateObj && (!$scheduleEndDate || $expiryDateObj->gt($scheduleEndDate))) {
                $needToExtend = true;
                $oldEndDate = $scheduleEndDate;

                $schedule->update([
                    'recurrence_end_date' => $expiry_date,
                    'updated_by' => Auth::id(),
                ]);

                // Create additional class instances for the extended period
                $this->createAdditionalClassInstances($schedule, $oldEndDate, $expiryDateObj);
            }

            // THIRD: Get ALL class instances (including newly created ones)
            // This query now runs AFTER instances are created
            $futureInstances = ClassInstance::where('schedule_id', $scheduleId)
                ->where('start_date', '>=', $enrolled_date)
                ->where('status', 'scheduled')
                ->orderBy('start_date', 'asc')
                ->get();

            // Check if any future instance is full
            foreach ($futureInstances as $instance) {
                if ($instance->available_spots <= 0) {
                    return redirect()->back()
                        ->with('error', "Cannot add member. Class on {$instance->start_date} is full.")
                        ->withInput();
                }
            }

            // FOURTH: Add member to all future class instances
            foreach ($futureInstances as $instance) {
                $instanceDate = Carbon::parse($instance->start_date);

                if ($instanceDate->gte($enrolledDateObj)) {
                    if ($expiryDateObj && $instanceDate->gt($expiryDateObj)) {
                        continue; // Skip if beyond member's expiry
                    }

                    // Check if member is already attached
                    $alreadyAttached = DB::table('class_instance_member')
                        ->where('class_instance_id', $instance->id)
                        ->where('member_id', $member_id)
                        ->exists();

                    if (!$alreadyAttached) {
                        $instance->member()->attach($member_id, [
                            'attendance_status' => null,
                            'check_in_time' => null,
                            'note' => 'Added on ' . now()->format('Y-m-d'),
                            'created_at' => now(),
                        ]);

                        // Update available spots
                        $instance->decrement('available_spots');
                    }
                }
            }

            return redirect()->route('classInstance.showToAdd', $scheduleId)
                ->with('success', 'Member added to schedule successfully!');
        } catch (\Exception $ex) {
            Log::error('Error adding member to schedule: ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error adding member: ' . $ex->getMessage())
                ->withInput();
        }
    }

    /**
     * Helper method to create additional class instances when schedule is extended
     */
    private function createAdditionalClassInstances($schedule, $oldEndDate, $newEndDate)
    {
        // Start from the day after the old end date
        $startDate = $oldEndDate ? Carbon::parse($oldEndDate)->addDay() : Carbon::parse($schedule->recurrence_start_date);
        $endDate = $newEndDate;
        $recurrenceType = $schedule->recurrence_type;
        $total_spots = $schedule->is_group ? 4 : 1;

        Log::info("Creating additional instances from {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}");

        $currentDate = clone $startDate;
        $maxIterations = 100; // Safety limit
        $iteration = 0;

        // Get all active members (including the newly added one)
        $activeMembers = $schedule->member()
            ->wherePivot('status', 'active')
            ->get();

        while ($currentDate->lte($endDate) && $iteration < $maxIterations) {
            $iteration++;

            // Check if instance already exists for this date
            $existingInstance = ClassInstance::where('schedule_id', $schedule->id)
                ->where('start_date', $currentDate->format('Y-m-d'))
                ->first();

            if (!$existingInstance) {
                // Count how many active members should be in this instance
                $attendeeCount = 0;
                $eligibleMembers = [];

                foreach ($activeMembers as $member) {
                    $memberEnrolledDate = Carbon::parse($member->pivot->enrolled_date);
                    $memberExpiryDate = $member->pivot->expiry_date ? Carbon::parse($member->pivot->expiry_date) : null;

                    if ($currentDate->gte($memberEnrolledDate)) {
                        if (!$memberExpiryDate || $currentDate->lte($memberExpiryDate)) {
                            $attendeeCount++;
                            $eligibleMembers[] = $member;
                        }
                    }
                }

                Log::info("Creating instance for {$currentDate->format('Y-m-d')} with {$attendeeCount} members");

                // Create class instance
                $classInstance = ClassInstance::create([
                    'schedule_id' => $schedule->id,
                    'trainer_id' => $schedule->trainer_id,
                    'course_id' => $schedule->course_id,
                    'start_date' => $currentDate->format('Y-m-d'),
                    'end_date' => $currentDate->format('Y-m-d'),
                    'day_of_week' => strtolower($currentDate->format('l')),
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'status' => 'scheduled',
                    'is_group' => $schedule->is_group,
                    'total_spots' => $total_spots,
                    'available_spots' => $total_spots - $attendeeCount,
                    'added_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Add all eligible members to this instance
                foreach ($eligibleMembers as $member) {
                    $classInstance->member()->attach($member->id, [
                        'attendance_status' => null,
                        'check_in_time' => null,
                        'note' => 'Auto-added from schedule extension',
                        'created_at' => now(),
                    ]);
                }
            } else {
                Log::info("Instance already exists for {$currentDate->format('Y-m-d')}");
            }

            // Move to next date based on recurrence type
            switch ($recurrenceType) {
                case 'daily':
                    $currentDate->addDay();
                    break;
                case 'weekly':
                    $currentDate->addWeek();
                    break;
                case 'biweekly':
                    $currentDate->addWeeks(2);
                    break;
                case 'monthly':
                    $currentDate->addMonth();
                    break;
                default:
                    $currentDate = $endDate->copy()->addDay(); // Break loop
            }
        }
    }
}
