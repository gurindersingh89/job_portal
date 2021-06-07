<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $jobs = Job::openJobs()->paginate(10);
        return view('job_lists', compact('jobs'));
    }
}
