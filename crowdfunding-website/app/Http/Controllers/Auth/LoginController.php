<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Email dan Password yang anda masukkan tidak sesuai.'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }
}
