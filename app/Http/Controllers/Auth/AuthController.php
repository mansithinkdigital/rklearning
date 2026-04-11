<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('admin.auth.login'); // Make sure this view file exists
    }
    // Register new admin user
    public function register()
    {
        $data = [
            'name' => "admin",
            'email' => "rklearning@gmail.com",
            'password' => Hash::make("123456"),
            'role' => "admin"
        ];
        $user = User::create($data);
        if ($user) {
            echo "Registerd successfully";
        } else {
            echo "something went wrong";
        }
    }
    // Handle Admin Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email', // Ensure the email exists
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect to dashboard if admin
            } else {
                Auth::logout(); // Logout if user is not admin
                return redirect()->route('admin.signIn')->with('error', 'You are not authorized to access this page.');
            }
        } else {
            return redirect()->route('admin.signIn')->with('error', 'Invalid email or password.');
        }
    }

    // Handle Admin Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Clears session
        $request->session()->regenerateToken(); // Regenerates CSRF token

        return redirect()->route('admin.signIn');
    }
}
