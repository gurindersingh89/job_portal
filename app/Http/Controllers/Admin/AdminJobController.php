<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminJobController extends Controller
{
    public function store(Request $request){
        $rules = [
            'title' => ['required', 'max:50'],
            'description' => ['required'],
            'qualification' => ['required'],
            'no_of_openings' => ['required', 'integer'],
            'department' => ['required', 'max:100'],
            'salary' => ['required', 'integer'],
        ];
        
        $validate_attributes = $this->validate($request, $rules);
        
        Job::create($validate_attributes);

        return response()->json('Job Added Successfully');
    }
}
