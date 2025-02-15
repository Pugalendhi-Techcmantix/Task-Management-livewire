<?php

namespace App\Http\Controllers;


class CommonController extends Controller
{

    public function login()
    {
        return view('login');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function chat_box()
    {
        return view('chat-box');
    }
    public function geminiai()
    {
        return view('gemini-ai');
    }

    public function profile()
    {
        return view('profile');
    }
}
