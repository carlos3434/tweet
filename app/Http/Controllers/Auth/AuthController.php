<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\User\UserForLogin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json($this->response($user), 201);
    }

    public function response($user){
        return new UserForLogin($user);
    }

    public function login(LoginRequest $request){
        if (!Auth::attempt( request(['email', 'password']) )) {
            return $this->unauthorized();
        }
        $user = Auth::user();
        return response()->json($this->response($user), 200);
    }

    public function logout( Request $request ) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' =>'session was closed']);
    }

    public function unauthorized() {
        return response()->json(['message' =>"unauthorized"], 401);
    }
}
