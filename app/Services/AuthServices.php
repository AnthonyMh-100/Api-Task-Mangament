<?php

namespace App\Services;
use App\Models\User;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServices
{

    public function loginService($credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return [
                'status' => false,
                'message' => 'Unauthorized',
                'token' => null
            ];
        }
        return [
            'status' => true,
            'message' => 'Login successful',
            'token' => $token
        ];
    }

    public function registerService($request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );

        $token = JWTAuth::fromUser($user);

        return [
            'message' => 'User registered  successfully!',
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer'
        ];
    }


}
