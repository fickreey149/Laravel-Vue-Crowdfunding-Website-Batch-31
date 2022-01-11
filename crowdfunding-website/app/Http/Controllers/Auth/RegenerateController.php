<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegenerateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Email yang anda masukkan tidak terdaftar.'
            ]);
        }

        $otp_codes = OtpCode::where('user_id', $user->id)->first();

        if (!$otp_codes) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Code tidak ditemukan.'
            ]);
        }

        $user->generateOtpCode();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silahkan cek email',
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
