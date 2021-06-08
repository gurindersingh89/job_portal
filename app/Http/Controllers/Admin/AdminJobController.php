<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminJobController extends Controller
{
    public function store(Request $request){
        $validate_attributes = $this->validateJob($request);
        
        $job = Job::create($validate_attributes);

        $data = ['status' => true, 'data' => $job, 'message' => 'Job Added Successfully'];
        return response()->json($data);
    }
    
    public function show(Job $job){
        $data = ['status' => true, 'data' => $job];
        return response()->json($data);
    }

    public function update(Request $request, Job $job){
        $validate_attributes = $this->validateJob($request);
        
        $job = $job->update($validate_attributes);

        $data = ['status' => true, 'data' => $job, 'message' => 'Job Updated Successfully'];
        return response()->json($data);
    }

    public function validateJob($request){
        $rules = [
            'title' => ['required', 'max:50'],
            'description' => ['required'],
            'qualification' => ['required'],
            'no_of_openings' => ['required', 'integer'],
            'department' => ['required', 'max:100'],
            'salary' => ['required', 'integer'],
        ];

        return $this->validate($request, $rules);
    }

    public function destroy(Job $job){
        $job->delete();
        return response()->json('', 204);
    }

    public function jobStatusUpdate(Request $request){
        $rules = [
            'id' => ['required', 'integer', 'exists:jobs'],
            'value' => ['required', 'in:Open,Close'],
        ];

        $this->validate($request, $rules);

        $job = Job::whereId($request->id)->update(['job_status' => $request->value]);

        $data = ['status' => true, 'data' => $job, 'message' => 'Job Status Updated'];
        return response()->json($data);
    }
}
