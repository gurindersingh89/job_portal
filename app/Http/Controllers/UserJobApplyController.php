<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserJobApplyController extends Controller
{
    public function jobApply(Request $request){
        $job = auth()->user()->jobUserApplies()->create($request->all());

        $data = ['status' => true, 'data' => $job, 'message' => 'Job Applied Successfully'];
        return response()->json($data);
    }

    public function jobRemove(Request $request){
        $job = auth()->user()->jobUserApplies()->whereJobId($request->job_id)->delete();

        $data = ['status' => true, 'data' => $job, 'message' => 'Job Remove Successfully'];
        return response()->json($data);
    }
}
