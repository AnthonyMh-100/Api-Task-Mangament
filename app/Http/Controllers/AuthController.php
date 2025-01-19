<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLogin;
use App\Http\Requests\RequestRegister;
use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServices $authService)
    {
        $this->authService = $authService;
    }
    
    public function login(RequestLogin $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $result = $this->authService->loginService($credentials);

            if (!$result['status']) {
                return response()->json(['error' => $result['message']], 401);
            }

            return response()->json($this->respondWithToken($result['token']), 200);
            
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);

        }
        
    }

    public function register(RequestRegister $request){
       
        try {

            $user = $this->authService->registerService($request);
            return response()->json($user, 201);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
        
    }
 
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    } 

    
}
