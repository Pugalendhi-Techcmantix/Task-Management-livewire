<?php

namespace App\Http\Controllers;


class StatusController extends Controller
{
 public function index(){
    return view('status-list');
 }
}
