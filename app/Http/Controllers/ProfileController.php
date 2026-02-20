<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        ActivityLog::log('Profile updated', 'User Profile', 'updated', $user);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the change password form.
     */
    public function changepassword()
    {
        return view('profile.changepassword', ['user' => Auth::user()]);
    }

    /**
     * Update the authenticated user's password.
     */
    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->fill([
            'password' => Hash::make($request->new_password),
        ])->save();

        ActivityLog::log('Password changed', 'User Profile', 'updated', $user);

        return back()->with('success', 'Password changed successfully.');
    }
}
