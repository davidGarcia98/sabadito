<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function login(){
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)){
            return response()->json(['error'=>'Credenciales no validas'],401);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $auxuser = auth()->user();
        return response()->json([
            'token' => $token,
            'access_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $auxuser,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['msj' => 'Sesión finalizada correctamente']);
    }

    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    public function me(){
        return response()->json(auth()->user());
    }

    public function register(Request $request){
        dd($request->all());
    }
}
