<?php


namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Course;
use App\Models\Member;
use App\Models\Plan;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $data = Member::orderBy('id', 'DESC')->paginate(2);

        return view('member.clean_index', ['data' => $data]);
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->name;
            $data = Member::where('name', 'like', "%{$name}%")->get();
            return view('member.search', ['data' => $data]);
        }
    }

    public function CheckExistsFirst(Request $request)
    {
        if ($request->ajax()) {
            $checkExistsBeforeCounter = get_count_where(new Member(), [
                'name' => $request->send_name_ajax,
                'email' => $request->send_email_ajax,
                "phone" => $request->send_phone_ajax
            ]);
            if ($checkExistsBeforeCounter > 0) {
                return json_encode("exists_before");
            } else {
                return json_encode("not_exists_before");
            }
        }
    }


    public function store(Request $request)
    {


        if ($request->ajax()) {
            //create account for this member
            $generate_random_code = generateNumeric(11);
            $create_member_account['name'] = 'Member ' . $request->send_name_ajax;
            $create_member_account['email'] = $request->send_email_ajax;
            $create_member_account['role'] = 'member';
            $create_member_account['phone'] = $request->send_phone_ajax;
            $create_member_account['address'] =  $request->send_address_ajax;
            $create_member_account['code'] =  $generate_random_code;
            $create_member_account['status'] =  'active';
            $create_member_account['created_at'] =  date("Y-m-d H:i:s");
            $create_member_account['password'] =   Hash::make($request->send_name_ajax);
            $successfully_created = User::create($create_member_account);
            if ($successfully_created) {
                if ($request->has('item_img')) {
                    $request->validate([
                        'item_img' => 'required|mimes:png,jpg,jpeg|max:5000',
                    ]);
                    $the_file_path = upload_image('admin/uploads', $request->item_img);
                    $dataToInsert['photo'] = $the_file_path;
                }


                $dataToInsert['name'] = $request->send_name_ajax;
                $dataToInsert['email'] = $request->send_email_ajax;
                $dataToInsert['phone'] = $request->send_phone_ajax;

                $dataToInsert['date_of_birth'] = $request->send_date_of_birth_ajax;
                $dataToInsert['gender'] = $request->send_gender_ajax;
                $dataToInsert['nationality'] = $request->send_nationality_ajax;
                $dataToInsert['address'] = $request->send_address_ajax;
                $dataToInsert['height'] = $request->send_height_ajax;
                $dataToInsert['weight'] = $request->send_weight_ajax;
                $dataToInsert['status'] = $request->send_status_ajax;
                $dataToInsert['added_by'] = Auth::user()->id;
                $dataToInsert['code'] = $successfully_created->code;
                $dataToInsert['created_at'] = date("Y-m-d H:i:s");

                Member::create($dataToInsert);
                return json_encode("done");
            }
        }
    }


    public function load_edit_row(Request $request)
    {
        if ($request->ajax()) {

            $data_row = get_cols_where_row(new Member(), ['*'], ['id' => $request->send_id_ajax, 'code' => $request->send_member_code_ajax]);

            return view('member.clean_edit_model', [
                'data_row' => $data_row,
            ]);
        }
    }

    public function update(Request $request)
    {

        $validator = validator($request->all(), [
            'send_name_ajax' => 'required|string|max:255',
            'send_email_ajax' => 'required|email|max:255|unique:members,email,' . $request->send_id_ajax,
            'send_phone_ajax' => 'required|string|min:10|max:20',
            'send_date_of_birth_ajax' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d'),
            'send_gender_ajax' => 'required|in:male,female',
            'send_nationality_ajax' => 'required|string|max:100',
            'send_status_ajax' => 'required|in:active,pending,suspended,expired,cancelled',
            'item_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->ajax()) {

            $data_row = get_cols_where_row(new Member(), ['*'], ['id' => $request->send_id_ajax]);
            if (!empty($data_row)) {


                if ($request->has('item_img')) {
                    $request->validate([
                        'item_img' => 'required|mimes:png,jpg,jpeg|max:5000',
                    ]);
                    $the_file_path = upload_image('admin/uploads', $request->item_img);
                    $dataToUpdate['photo'] = $the_file_path;
                }


                $dataToUpdate['name'] = $request->send_name_ajax;
                $dataToUpdate['email'] = $request->send_email_ajax;
                $dataToUpdate['phone'] = $request->send_phone_ajax;

                $dataToUpdate['date_of_birth'] = $request->send_date_of_birth_ajax;
                $dataToUpdate['gender'] = $request->send_gender_ajax;
                $dataToUpdate['nationality'] = $request->send_nationality_ajax;
                $dataToUpdate['address'] = $request->send_address_ajax;
                $dataToUpdate['height'] = $request->send_height_ajax;
                $dataToUpdate['weight'] = $request->send_weight_ajax;
                $dataToUpdate['status'] = $request->send_status_ajax;
                $dataToUpdate['updated_by'] = Auth::user()->id;
                $dataToUpdate['updated_at'] = date("Y-m-d H:i:s");
                Member::where(['id' => $request->send_id_ajax, 'code' => $request->send_code_ajax])->update($dataToUpdate);
                return json_encode("done");
            }
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {


            $data_row = get_cols_where_row(new Member(), ['id', 'code'], ['id' => $request->send_id_ajax, 'code' => $request->send_member_code_ajax]);
            if (!empty($data_row)) {
                Member::where(['id' => $request->send_id_ajax, 'code' => $request->send_member_code_ajax])->delete();

                return json_encode("done");
            } else {
                return json_encode("Sorry! data is not found");
            }
        }

        /* if ($request->ajax()) {
            $data = [
                'message' => 'done',
                'send_id' => $request->send_id_ajax,
                'member_code' => $request->send_member_code_ajax
            ];

            return response()->json($data);
        } */
    }


    public function subscibe($id)
    {
        /* $data = Plan::where('id', $id)->get(); */
        $get_member = Member::find($id);
        return view('member.clean_plan', ['get_member' => $get_member]);
    }


    public function get_member_courses(Request $request)
    {

        $memberId = $request->query('member_id');
        $member_data = Member::find($memberId);
        $data = Course::orderBy('id', 'DESC')->get();


        return view('course.clean_index', ['member_data' => $member_data, 'data' => $data]);
    }
}
