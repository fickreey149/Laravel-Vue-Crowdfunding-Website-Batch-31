<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
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
            'otp' => 'required|integer|digits:6'
        ]);

        $otp_codes = OtpCode::where('otp', $request->otp)->first();

        if (!$otp_codes) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP code yang anda masukkan salah'
            ]);
        }

        $now = Carbon::now();

        if ($now > $otp_codes->valid_until) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Kode OTP sudah kadaluarsa, silahkan regenerate kode OTP.'
            ]);
        }

        // update email_verified_at user
        $user = User::findOrFail($otp_codes->user_id);
        $user->email_verified_at = $now;
        $user->save();

        // delete otp_codes
        $otp_codes->delete();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Selamat, verifikasi berhasil.'
        ]);
    }
}
