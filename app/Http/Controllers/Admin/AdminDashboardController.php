<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\User;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard(){
        $open_jobs = Job::openJobs()->count();
        $close_jobs = Job::closeJobs()->count();
        $users = User::userType()->count();
        return view('admin.dashboard', compact('open_jobs', 'close_jobs', 'users'));
    }
}
