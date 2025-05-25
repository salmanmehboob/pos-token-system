<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('profiles.admin', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'oldpassword' => 'nullable|string',
            'newpassword' => 'nullable|string|min:8|confirmed',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;

        if ($request->filled('oldpassword') && $request->filled('newpassword')) {
            if (!Hash::check($request->oldpassword, $user->password)) {
                return back()->withErrors(['oldpassword' => 'Old password is incorrect']);
            }

            $user->password = Hash::make($request->newpassword);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}