<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    /**
     * Show student registration form.
     */
    public function registerForm()
    {
        $branches = Branch::all();
        return view('student.auth.register', compact('branches'));
    }

    /**
     * Handle student registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'branch_id' => 'required|exists:branches,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->move(public_path('student/uploads/registerimg'), $imageName);
            $imagePath = 'student/uploads/registerimg/' . $imageName;
        }

        $user = User::create([
            'name' => $request->name,
            'mother_name' => $request->mother_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'branch_id' => $request->branch_id,
            'image' => $imagePath,
            'password' => Hash::make($request->password),
            'role' => 'student'
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($request->redirect_to) {
            return redirect($request->redirect_to);
        }

        return redirect()->intended(route('student.dashboard'));
    }

    /**
     * Show student login form.
     */
    public function loginForm()
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }
        return view('student.auth.login');
    }

    /**
     * Handle student login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->role === 'student') {
                $request->session()->regenerate();
                
                if ($request->redirect_to) {
                    return redirect($request->redirect_to);
                }
                
                return redirect()->intended(route('student.dashboard'));
            }

            // If not student, logout and redirect with error
            Auth::logout();
            return back()->withErrors([
                'email' => 'The provided credentials do not match our student records.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle student logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
