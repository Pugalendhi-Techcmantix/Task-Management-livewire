<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    public function employee_list()
    {
        return view('employee-list');
    }
    public function role_list()
    {
        return view('role-list');
    }
    public function task_list()
    {
        return view('task-list');
    }
    public function support_list()
    {
        return view('support-list');
    }
}
