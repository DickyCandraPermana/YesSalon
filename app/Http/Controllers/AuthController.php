<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // get user
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    // logout
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Logged out']);
    }

    // refresh token
    // public function refresh()
    // {
    //     return $this->respondWithToken(Auth::guard('api')->refresh());
    // }

    protected function respondWithToken($token)
    {
        $ttl = config('jwt.ttl'); // minutes

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $ttl * 60 // seconds
        ]);
    }
}
