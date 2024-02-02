<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        if (! Auth::attempt($request->validated())) {
            return response()->json(['message' => 'Incorrect email or password'] , 401);
        }
        $user = $request->user();
        $token = $user->createToken("login Token")->plainTextToken;
        return LoginResource::make(compact('token','user'));
    }
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'user logout successfully'
        ] , 200);
    }
}
