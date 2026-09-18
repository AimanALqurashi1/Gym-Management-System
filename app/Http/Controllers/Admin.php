<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class Admin extends Controller
{



    public function index()
    {

        $data = Member::all(); // Adjust pagination as needed

        return view('admin.members.index', ['data' => $data]);
    }
}
