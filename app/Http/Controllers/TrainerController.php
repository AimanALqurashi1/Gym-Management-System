<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainerRequest;
use App\Models\Course;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{

    public function index()
    {
        // Get trainers with their courses
        $trainers = Trainer::with('courses')->orderBy('id', 'DESC')->get();

        // Transform the data in controller
        if ($trainers->isNotEmpty()) {
            foreach ($trainers as $trainer) {
                $trainer['has_courses'] = $trainer->courses->isNotEmpty();
                $trainer['courses_list'] = $trainer->courses;
                $trainer['course_names'] = $trainer->courses->pluck('name')->toArray();
                $trainer['course_names_string'] = $trainer->courses->pluck('name')->implode(', ');

                // Add photo URL
                if (!empty($trainer->photo) && $trainer->photo !== null) {
                    $trainer->photo_url = asset('admin/uploads/' . $trainer->photo);
                } else {
                    $trainer->photo_url = $trainer->gender == 'female'
                        ? asset('admin/uploads/femaleLogo.jpg')
                        : asset('admin/uploads/maleLogo.png');
                }
            }
        }

        $course_data = Course::orderBy('id', 'DESC')->get();

        return view('trainer.clean_index', [
            'data' => $trainers,
            'course_data' => $course_data
        ]);
    }

    public function create()
    {
        return view('trainer.create');
    }

    public function store(TrainerRequest $request)
    {

        //create account for this trainer
        $create_trainer_account['name'] = 'Trainer ' . $request->name;
        $create_trainer_account['email'] = $request->email;
        $create_trainer_account['role'] = 'trainer';
        $create_trainer_account['phone'] = $request->phone;
        $create_trainer_account['address'] = $request->address;
        $create_trainer_account['status'] = 'active';
        $create_trainer_account['created_at'] = date("Y-m-d H:i:s");
        $create_trainer_account['password'] = Hash::make($request->name);
        $successfully_created = User::create($create_trainer_account);

        //add the trainer to trainers table
        if ($successfully_created) {
            $trainer_created_account_id = $successfully_created->id;

            $dataToInsert = [];

            if ($request->hasFile('item_img')) {
                $file = $request->file('item_img');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('admin/uploads'), $filename);
                $dataToInsert['photo'] = $filename;
            }

            $generate_random_code = 'TRN' . strtoupper(uniqid());

            $dataToInsert['name'] = $request->name;
            $dataToInsert['email'] = $request->email;
            $dataToInsert['phone'] = $request->phone;
            $dataToInsert['user_id'] = $trainer_created_account_id;
            $dataToInsert['date_of_birth'] = $request->date_of_birth;
            $dataToInsert['gender'] = $request->gender;
            $dataToInsert['nationality'] = $request->nationality;
            $dataToInsert['address'] = $request->address;
            $dataToInsert['height'] = $request->height;
            $dataToInsert['weight'] = $request->weight;
            $dataToInsert['status'] = $request->status;
            $dataToInsert['added_by'] = Auth::user()->id;
            $dataToInsert['code'] = $generate_random_code;
            $dataToInsert['created_at'] = date("Y-m-d H:i:s");

            Trainer::create($dataToInsert);

            return redirect()->route('trainer.index')->with('success', 'Trainer created successfully!');
        }

        return redirect()->back()->with('error', 'Failed to create trainer.')->withInput();
    }

    public function show($id)
    {
        $trainer = Trainer::with('courses')->findOrFail($id);

        // Add photo URL
        if (!empty($trainer->photo) && $trainer->photo !== null) {
            $trainer->photo_url = asset('admin/uploads/' . $trainer->photo);
        } else {
            $trainer->photo_url = $trainer->gender == 'female'
                ? asset('admin/uploads/femaleLogo.jpg')
                : asset('admin/uploads/maleLogo.png');
        }

        // Get statistics
        $stats = [
            'total_courses' => $trainer->courses->count(),
            'total_schedules' => $trainer->schedules()->count(),
            'total_classes' => $trainer->classInstances()->count(),
        ];

        return view('trainer.show', compact('trainer', 'stats'));
    }

    public function edit($id)
    {
        $trainer = Trainer::with('courses')->findOrFail($id);

        // Add photo URL
        if (!empty($trainer->photo) && $trainer->photo !== null) {
            $trainer->photo_url = asset('admin/uploads/' . $trainer->photo);
        } else {
            $trainer->photo_url = $trainer->gender == 'female'
                ? asset('admin/uploads/femaleLogo.jpg')
                : asset('admin/uploads/maleLogo.png');
        }

        return view('trainer.edit', compact('trainer'));
    }

    public function update(Request $request, $id)
    {
        $trainer = Trainer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100|regex:/^[a-zA-Z\s\.\-]+$/',
            'email' => 'required|email|unique:users,email,' . $trainer->user_id,
            'phone' => 'required|string|min:8|max:20',
            'date_of_birth' => 'required|date|before:today|after:1920-01-01',
            'gender' => 'required|in:male,female',
            'nationality' => 'required|string|min:2|max:100',
            'address' => 'nullable|string|max:500',
            'height' => 'nullable|numeric|min:50|max:300',
            'weight' => 'nullable|numeric|min:10|max:500',
            'status' => 'required|in:0,1',
            'item_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle photo upload
        if ($request->hasFile('item_img')) {
            // Delete old photo if exists
            if ($trainer->photo && file_exists(public_path('admin/uploads/' . $trainer->photo))) {
                unlink(public_path('admin/uploads/' . $trainer->photo));
            }

            $file = $request->file('item_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/uploads'), $filename);
            $trainer->photo = $filename;
        }

        // Update trainer data
        $trainer->name = $request->name;
        $trainer->email = $request->email;
        $trainer->phone = $request->phone;
        $trainer->date_of_birth = $request->date_of_birth;
        $trainer->gender = $request->gender;
        $trainer->nationality = $request->nationality;
        $trainer->address = $request->address;
        $trainer->height = $request->height;
        $trainer->weight = $request->weight;
        $trainer->status = $request->status;
        $trainer->updated_by = Auth::user()->id;
        $trainer->updated_at = now();
        $trainer->save();

        // Update user account
        if ($trainer->user_id) {
            $user = User::find($trainer->user_id);
            if ($user) {
                $user->name = 'Trainer ' . $request->name;
                $user->phone = $request->phone;
                $user->address = $request->address;
                $user->save();
            }
        }

        return redirect()->route('trainer.index')->with('success', 'Trainer updated successfully!');
    }

    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);

        // Delete photo
        if ($trainer->photo && file_exists(public_path('admin/uploads/' . $trainer->photo))) {
            unlink(public_path('admin/uploads/' . $trainer->photo));
        }

        // Delete associated user account
        if ($trainer->user_id) {
            User::where('id', $trainer->user_id)->delete();
        }

        $trainer->delete();

        return redirect()->route('trainer.index')->with('success', 'Trainer deleted successfully!');
    }

    public function loadAssignForm(Request $request)
    {
        $trainer = Trainer::with('courses')->find($request->trainer_id);
        $courses = Course::orderBy('id', 'DESC')->get();
        $assignedCourseIds = $trainer->courses->pluck('id')->toArray();

        return view('trainer.assign-form', compact('trainer', 'courses', 'assignedCourseIds'));
    }

    public function assignCourses(Request $request)
    {
        try {
            $trainer = Trainer::findOrFail($request->trainer_id);
            $courseIds = $request->has('course_ids') ? $request->course_ids : [];
            $trainer->courses()->sync($courseIds);

            return response()->json([
                'success' => true,
                'message' => 'Courses assigned successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning courses: ' . $e->getMessage()
            ], 500);
        }
    }

    public function specific_trainer_courss($id)
    {
        $trainer_data = Trainer::with('courses')->find($id);

        if (!$trainer_data) {
            return redirect()->back()->with('error', 'Trainer not found!');
        }

        if ($trainer_data->courses->isEmpty()) {
            return redirect()->back()->with('error', 'This trainer has no courses yet.');
        }

        $data = $trainer_data->courses;

        return view('course.clean_index', [
            'trainer_data' => $trainer_data,
            'data' => $data,
            'fromTrainerCourses' => true
        ]);
    }
}
