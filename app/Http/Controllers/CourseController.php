<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $data = Course::orderBy('id', 'DESC')->get();

        return view('course.clean_index', ['data' => $data]);
    }
}
