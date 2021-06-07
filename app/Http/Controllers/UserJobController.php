<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserJobController extends Controller
{
    public function index(){
        $jobs = [];
        return view('job_lists', compact('jobs'));
    }
}
