<?php

namespace App\Http\Controllers;


class UserController extends Controller
{
    public function pending()
    {
        return view('pending');
    }
    public function progress()
    {
        return view('progress');
    }
    public function hold()
    {
        return view('hold');
    }
    public function completed()
    {
        return view('completed');
    }
    public function support_page()
    {
        return view('support-page');
    }
    public function sample()
    {
        return view('task-kanban-board');
    }
   
}
