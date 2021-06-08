<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $jobs = Job::withCount(['jobApplies' => function ($query) {
            $query->whereUserId(auth()->user()->id);
        }])
            ->openJobs()
            ->paginate(10);

        return view('job_lists', compact('jobs'));
    }
}
