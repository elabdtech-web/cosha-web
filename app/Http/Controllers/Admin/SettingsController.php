<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function edit()
    {
        $authId = auth()->user()->id;
        $user = User::where('id', $authId)
            ->with('admin')
            ->first();
        return view('admin.settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $admin = $user->admin;  // assuming User has a one-to-one relationship with Admin

        // Update profile image in the Admin table
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/profile', $imageName);

            // Save the image in the 'profile_image' field of the Admin table
            $admin->profile_image = $imageName;
            $admin->save();
        }

        // Update password and email in the User table
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

}
