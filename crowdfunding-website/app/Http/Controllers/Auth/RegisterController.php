<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
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
}
