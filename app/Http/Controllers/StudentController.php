<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public $id;
    public function viewList()
    {

        return view('students');
    }
    public function viewForm()
    {
        return view('student-add');
    }

    public function editForm($id)
    {
        // Pass the student data to the view
        return view('student-edit', ['student_id' => $id]);
    }
}
