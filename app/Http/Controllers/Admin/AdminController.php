<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard(){
        // $jobs = Job::paginate(10);
        $jobs = array();
        return view('admin.dashboard', compact('jobs'));
    }
}
