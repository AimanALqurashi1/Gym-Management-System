<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegister()
    {

        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:500',
            'terms' => 'required|accepted',
            'email' => 'required|email|max:255|unique:members,email',
            'date_of_birth' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d'),
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|min:10|max:20|regex:/^([0-9\s\-\+\(\)]*)$/',
            'weight' => 'nullable|numeric|min:30|max:300',
            'height' => 'nullable|numeric|min:50|max:250',
            'nationality' => 'required|string|max:100',
            'role' => 'required|in:member,trainer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }




        $checkEmail_exist = User::where('email', $request)->first();
        if ($checkEmail_exist) {
            return redirect()->back()
                ->with('error', 'This email has been regitered');
        }

        if ($request->role == 'member') {

            $generate_random_code = generateNumeric(11);
            $create_member_account['name'] = 'Member ' . $request->name;
            $create_member_account['email'] = $request->email;
            $create_member_account['role'] = 'member';
            $create_member_account['phone'] = $request->phone;
            $create_member_account['address'] =  $request->address;
            $create_member_account['code'] =  $generate_random_code;
            $create_member_account['status'] =  'inactive';
            $create_member_account['created_at'] =  date("Y-m-d H:i:s");
            $create_member_account['password'] =   Hash::make($request->password);
            $successfully_created = User::create($create_member_account);
            if ($successfully_created) {
                if ($request->has('photo')) {
                    $request->validate([
                        'photo' => 'required|mimes:png,jpg,jpeg|max:5000',
                    ]);
                    $the_file_path = upload_image('admin/uploads', $request->photo);
                    $dataToInsert['photo'] = $the_file_path;
                }


                $dataToInsert['name'] = $request->name;
                $dataToInsert['email'] = $request->email;
                $dataToInsert['phone'] = $request->phone;

                $dataToInsert['date_of_birth'] = $request->date_of_birth;
                $dataToInsert['gender'] = $request->gender;
                $dataToInsert['nationality'] = $request->nationality;
                $dataToInsert['address'] = $request->address;
                $dataToInsert['height'] = $request->height;
                $dataToInsert['weight'] = $request->weight;
                $dataToInsert['status'] = 'active';
                $dataToInsert['added_by'] = $successfully_created->id;
                $dataToInsert['code'] = $successfully_created->code;
                $dataToInsert['created_at'] = date("Y-m-d H:i:s");

                Member::create($dataToInsert);
            }

            return redirect()->route('login')->with(['success' => 'the new user has been registred successfuly ,please wait activation']);
        }


        if ($request->role == 'trainer') {
            //create account for this trainer
            $create_trainer_account['name'] = 'Trainer ' . $request->name;
            $create_trainer_account['email'] = $request->email;
            $create_trainer_account['role'] = 'trainer';
            $create_trainer_account['phone'] = $request->phone;
            $create_trainer_account['address'] = $request->address;
            $create_trainer_account['status'] = 'inactive';
            $create_trainer_account['created_at'] = date("Y-m-d H:i:s");
            $create_trainer_account['password'] = Hash::make($request->password);
            $successfully_created = User::create($create_trainer_account);

            //add the trainer to trainers table
            if ($successfully_created) {
                $trainer_created_account_id = $successfully_created->id;

                $dataToInsert = [];

                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
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
                $dataToInsert['status'] = 1;
                $dataToInsert['added_by'] = $successfully_created->id;
                $dataToInsert['code'] = $generate_random_code;
                $dataToInsert['created_at'] = date("Y-m-d H:i:s");

                Trainer::create($dataToInsert);

                return redirect()->route('login')->with('success', 'Trainer created successfully, please wait activation');
            }
        }
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Check if user is active - USE SESSION MESSAGE INSTEAD OF ERROR
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('inactive_account', 'Your account is not active right now. Please wait for admin activation.');
            }

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'user') {
                return redirect()->route('user.dashboard');
            }
            if ($user->role === 'trainer') {
                return redirect()->route('trainer.dashboard');
            }
            return redirect()->route('member.dashboard');
        }

        // Invalid credentials - USE SESSION MESSAGE
        return redirect()->back()
            ->with('login_error', 'Invalid email or password. Please try again.')
            ->withInput($request->only('email'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
