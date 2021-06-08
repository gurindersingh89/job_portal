<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index(){
        $users = User::userType()->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }
    
    public function show(User $user){
        $data = ['status' => true, 'data' => $user];
        return response()->json($data);
    }

    public function update(Request $request, User $user){
        $validate_attributes = $this->validateUser($request, $user);
        
        $user = $user->update($validate_attributes);

        $data = ['status' => true, 'data' => $user, 'message' => 'User Updated Successfully'];
        return response()->json($data);
    }

    public function validateUser($request, $user){
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id),],
        ];

        return $this->validate($request, $rules);
    }

    public function destroy(User $user){
        $user->delete();
        return response()->json('', 204);
    }
}
