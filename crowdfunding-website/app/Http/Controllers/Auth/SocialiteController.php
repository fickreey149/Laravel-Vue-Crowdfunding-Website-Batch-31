<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'url' => $url
        ]);
    }

    public function handleProviderCallback($provider)
    {
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();

            if (!$social_user) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Login Failed'
                ], 401);
            }

            $user = User::whereEmail($social_user->email)->first();

            if (!$user) {
                if ($provider == 'google') {
                    $photo = $social_user->avatar;
                }

                $user = User::create([
                    'email' => $social_user->email,
                    'name' => $social_user->name,
                    'email_verified_at' => Carbon::now(),
                    'photo' => $photo
                ]);
            }

            $data['user'] = $user;
            $data['token'] = auth()->login($user);

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Login Success',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Login Failed',
            ], 401);
        }
    }
}
