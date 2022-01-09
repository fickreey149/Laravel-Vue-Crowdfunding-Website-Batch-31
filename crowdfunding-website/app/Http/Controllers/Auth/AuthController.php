<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());

        OtpCode::create([
            'otp' => random_int(100000, 999999),
            'valid_until' => Carbon::now()->addMinutes(5),
            'user_id' => $user->id
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silahkan cek email',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function verification(Request $request)
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

    public function regenerate(Request $request)
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

        $otp_codes->update([
            'otp' => random_int(100000, 999999),
            'valid_until' => Carbon::now()->addMinutes(5)
        ]);

        $otp_codes->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silahkan cek email',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Email yang anda masukkan tidak terdaftar.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Password berhasil diupdate.',
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
