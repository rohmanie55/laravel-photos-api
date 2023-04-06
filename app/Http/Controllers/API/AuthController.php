<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($validated)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $tokenResult = $request->user()->createToken('authToken');

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at
        ]);
    }
    
    public function register(Request $request){
        $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $tokenResult = $user->createToken('authToken');

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at
        ]);
    }

    public function user(){
        return response()->json(auth()->user());
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}
