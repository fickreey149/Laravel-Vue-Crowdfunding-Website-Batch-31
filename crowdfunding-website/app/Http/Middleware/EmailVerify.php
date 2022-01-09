<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class EmailVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->isVerification()) {
            return $next($request);
        }

        return response()->json([
            'response_code' => '01',
            'response_message' => 'Request gagal ! Ini disebabkan karena anda belum melakukan verifikasi email. Silahkan melakukan verifikasi email terlebih dahulu'
        ]);
    }
}
