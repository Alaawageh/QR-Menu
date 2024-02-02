<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return UserResource::collection(User::all());
    }
    public function show(User $user) {
        return UserResource::make($user);
    }
    public function store(AddUserRequest $request) {
        $request->validated();
        $user = User::create(array_merge($request->except('password'),['password' => bcrypt($request->password)]));
        return response()->json(['data' => $user ,'message' => 'The data has been saved successfully']);
    }
    public function update(EditUserRequest $request , User $user) {
        $request->validated();
        $user->update(array_merge($request->except('password'),['password' => bcrypt($request->password)]));
        return response()->json(['data' => $user ,'message' => 'The data has been updated successfully']);
    }
    public function destroy(User $user) {
        $user->delete();
        return response()->json(['message' => 'The data has been deleted successfully']);
    }
}
