<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    public function index(){
        return view('user.profile');
    }

    public function store(Request $request){
        // $validate_attributes = $this->validateUserProfile($request);

        // $user_profile = UserProfile::create($request->all());
        auth()->user()->userProfile()->create($request->all());

        return redirect('/')->with('success', 'Profile Update');
    }
    
    public function show(UserProfile $user_profile){
        $data = ['status' => true, 'data' => $user_profile];
        return response()->json($data);
    }

    public function update(Request $request, UserProfile $user_profile){
        $validate_attributes = $this->validateUserProfile($request);
        
        $user_profile = $user_profile->update($validate_attributes);

        $data = ['status' => true, 'data' => $user_profile, 'message' => 'UserProfile Updated Successfully'];
        return response()->json($data);
    }

    public function validateUserProfile($request){
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

}
