<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentRegistrationOtpMail;

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
     * Send OTP to email for registration verification (AJAX).
     */
    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Check if email is already registered
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered. Please login instead.'
            ], 422);
        }

        $otp = rand(100000, 999999);

        // Store OTP with 'reg_' prefix to distinguish from password reset OTPs
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => 'reg_' . $request->email],
            [
                'token' => $otp,
                'created_at' => now()
            ]
        );

        try {
            Mail::to($request->email)->send(new StudentRegistrationOtpMail($otp));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }

        // Store verified email in session for later use
        $request->session()->put('registration_otp_email', $request->email);

        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent to your email address.'
        ]);
    }

    /**
     * Verify the registration OTP (AJAX).
     */
    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', 'reg_' . $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.'
            ], 422);
        }

        // Check if OTP is expired (10 minutes)
        if (now()->diffInMinutes($record->created_at) > 10) {
            DB::table('password_reset_tokens')->where('email', 'reg_' . $request->email)->delete();
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.'
            ], 422);
        }

        // Mark email as verified in session
        $request->session()->put('registration_email_verified', $request->email);

        // Clean up the OTP record
        DB::table('password_reset_tokens')->where('email', 'reg_' . $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!'
        ]);
    }

    /**
     * Handle student registration.
     */
    public function register(Request $request)
    {
        // Verify that the email was OTP-verified during registration
        $verifiedEmail = $request->session()->get('registration_email_verified');
        if (!$verifiedEmail || $verifiedEmail !== $request->email) {
            return back()->withErrors(['email' => 'Please verify your email with OTP before registering.'])->withInput();
        }

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

        // Clean up registration session data
        $request->session()->forget(['registration_email_verified', 'registration_otp_email']);

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

    public function forgotPasswordForm()
    {
        return view('student.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => now()
            ]
        );

        \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\StudentOtpMail($otp));

        $request->session()->put('reset_email', $request->email);

        return redirect()->route('student.password.verify-otp')->with('success', 'OTP has been sent to your email.');
    }

    public function verifyOtpForm(Request $request)
    {
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('student.password.request');
        }
        return view('student.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $email = $request->session()->get('reset_email');

        $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP entered.']);
        }

        $request->session()->put('otp_verified', true);
        return redirect()->route('student.password.reset')->with('success', 'OTP verified successfully.');
    }

    public function resetPasswordForm(Request $request)
    {
        if (!$request->session()->get('otp_verified')) {
            return redirect()->route('student.password.request');
        }
        return view('student.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = $request->session()->get('reset_email');

        if (!$email || !$request->session()->get('otp_verified')) {
            return redirect()->route('student.password.request');
        }

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $email)->delete();
        $request->session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('student.login')->with('success', 'Password has been reset successfully. You can now login.');
    }
}
