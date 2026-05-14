<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show Contact Page
     */
    public function contact()
    {
        $this->generateCaptcha();
        return view('client.contact');
    }

    /**
     * Generate Random Captcha
     */
    private function generateCaptcha()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';
        for ($i = 0; $i < 5; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }
        session(['captcha_code' => $captcha]);
        return $captcha;
    }

    /**
     * Store Contact Form
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:20',
            'email' => 'required|email',
            'message' => 'required',
            'captcha' => 'required',
        ]);
        // CAPTCHA CHECK
        if (
            strtoupper($request->captcha) !=
            session('captcha_code')
        ) {
            return back()
                ->withInput()
                ->with('captcha_error', 'Invalid Captcha');
        }
        Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        // regenerate captcha
        $this->generateCaptcha();
        return back()->with('success', 'Inquiry submitted successfully.');
    }

    /**
     * Refresh Captcha
     */
    public function refreshCaptcha()
    {
        return response()->json([
            'captcha' => $this->generateCaptcha()
        ]);
    }
}
