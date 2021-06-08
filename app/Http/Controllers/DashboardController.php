<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id ?? '';
        $jobs = Job::withCount(['jobApplies' => function ($query) use($user_id){
            if($user_id)
                $query->whereUserId($user_id);
        }])
            ->openJobs()
            ->paginate(10);

        return view('job_lists', compact('jobs'));
    }
}
