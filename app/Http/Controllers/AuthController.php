<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(Request $request){
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User([
            'name' => $request-> name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            // $user = Auth::getProvider()->retrieveByCredentials($credentials);
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
        }else{
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
    }
}