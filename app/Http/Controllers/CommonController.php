<?php

namespace App\Http\Controllers;


class CommonController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function chat_box()
    {
        return view('chat-box');
    }
}
