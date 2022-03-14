<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::whereEmail($request->email)->first();
            $token = $user->createToken($request->email);

            return response()->json([
                'success'=> true,
                'message'=> 'Logged in successfully.',
                'token'=> $token->plainTextToken
            ]);
        }

        return response()->json([
            'success'=> false,
            'message'=> 'Log in failed.',
            'token'=> null
        ], 403);
    }
}
