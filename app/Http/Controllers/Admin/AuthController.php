<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // load login form
    public function login()
    {
        // if authenticated then redirect to dashboard
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // post login
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // If validation passes, continue with your logic

        $credentials = $request->only('email', 'password');

        // Check if email exist in users
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // return as validation error
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        // Attempt to log the user in
        if (auth()->attempt($credentials)) {
            // Redirect to the intended page
            return redirect()->route('admin.dashboard');
        }


        return back()->withErrors([
            'email' => 'Unable to login with provided credentials.',
        ]);
    }
}
