<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

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
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    // register
    public function register(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);


        // 3. Langsung generate token untuk user yang baru dibuat
        //    Tidak perlu menggunakan Auth::attempt() lagi karena user sudah terverifikasi
        $token = Auth::guard('api')->login($user);
        event(new Registered($user));

        // 4. Kembalikan respons dengan token
        return $this->respondWithToken($token);
    }

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
