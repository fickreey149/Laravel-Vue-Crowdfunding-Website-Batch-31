<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function get_profile()
    {
        $user = Auth::user();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data Profile berhasil ditampilkan.',
            'data' => [
                'profile' => $user
            ]
        ]);
    }

    public function update_profile(Request $request, User $user)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['nullable', 'string', 'min:3', 'max:50'],
            'username' => ['nullable', 'string', 'min:3', 'max:50', Rule::unique('users')->ignore($user->id, 'id')],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png,gif,svg']
        ]);

        if ($request->file('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
        }


        $request->file('photo')->move('photos/users/photo_profile', $name);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'photo' => 'photos/users/photo_profile/' . $name
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data Profile berhasil diupdate.',
            'data' => [
                'profile' => $user
            ]
        ]);
    }
}
