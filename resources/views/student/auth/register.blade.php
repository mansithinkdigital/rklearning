<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Registration - Rk Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Scripts & Styles -->
    <link rel="icon" type="image/png" href="{{ asset('admin/asset/favicons/favicon.png') }}">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #F8FAFC;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2rem;
        }

        /* OTP Input Styles */
        .otp-input-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .otp-input-group input {
            width: 48px;
            height: 54px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
            background: #f8fafc;
            color: #1e293b;
        }

        .otp-input-group input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: #fff;
        }

        .otp-input-group input.filled {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        /* Status badge styles */
        .email-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .email-status.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .email-status.sending {
            background: #dbeafe;
            color: #1e40af;
        }

        .email-status.sent {
            background: #dbeafe;
            color: #1e40af;
        }

        .email-status.verified {
            background: #dcfce7;
            color: #166534;
        }

        .email-status.error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Slide animation for OTP section */
        .otp-section {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease, padding 0.3s ease;
            opacity: 0;
        }

        .otp-section.active {
            max-height: 300px;
            opacity: 1;
        }

        /* Pulse animation for send button */
        @keyframes subtle-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(59, 130, 246, 0);
            }
        }

        .pulse-btn {
            animation: subtle-pulse 2s infinite;
        }

        /* Checkmark animation */
        @keyframes checkmark-pop {
            0% {
                transform: scale(0);
            }

            60% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .verified-check {
            animation: checkmark-pop 0.4s ease forwards;
        }

        /* Timer ring */
        .timer-text {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }

        /* Disabled overlay */
        .fields-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 glass-card shadow-2xl overflow-hidden">
        <!-- Decoration -->
        <div class="hidden md:flex bg-blue-600 p-12 flex-col justify-between text-white relative">
            <div class="relative z-10">
                <img src="{{ asset('assets/RK LOGO.png') }}" class="h-25 mb-8 w-[370px] object-contain">
                <h2 class="text-4xl font-bold mb-6">Join the Rk Institute Community</h2>
                <p class="text-blue-100 text-lg">Start your journey from Classroom to Cloud today. Get access to premium
                    courses and expert mentorship.</p>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        </div>
        <!-- Form -->
        <div class="p-8 md:p-12 bg-white">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Create Account</h3>
                <p class="text-slate-500">Sign up for your free student account.</p>
            </div>
            <form id="registerForm" action="{{ route('student.register.submit') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
                @if($errors->any())
                <div class="px-4 py-3 rounded-xl bg-red-50 text-red-600 text-sm font-medium">
                    {{ $errors->first() }}
                </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="Enter Full Name">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Mother Name</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="Enter Mother Name">
                    </div>
                </div>

                <!-- Email with OTP Verification -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-bold text-slate-700">Email Address</label>
                        <span id="emailStatus" class="email-status pending">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="5" />
                            </svg>
                            Not Verified
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <input type="email" name="email" id="emailInput" value="{{ old('email') }}" required
                            class="flex-1 px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="name@example.com">
                        <button type="button" id="sendOtpBtn" onclick="sendOtp()"
                            class="px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all whitespace-nowrap pulse-btn disabled:opacity-50 disabled:cursor-not-allowed disabled:animate-none">
                            Send OTP
                        </button>
                    </div>
                </div>

                <!-- OTP Verification Section (hidden initially) -->
                <div id="otpSection" class="otp-section">
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-blue-800">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Enter the 6-digit OTP sent to your email
                            </p>
                            <span id="otpTimer" class="timer-text"></span>
                        </div>
                        <div class="otp-input-group mb-3">
                            <input type="text" maxlength="1" class="otp-digit" data-index="0" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                            <input type="text" maxlength="1" class="otp-digit" data-index="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                            <input type="text" maxlength="1" class="otp-digit" data-index="2" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                            <input type="text" maxlength="1" class="otp-digit" data-index="3" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                            <input type="text" maxlength="1" class="otp-digit" data-index="4" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                            <input type="text" maxlength="1" class="otp-digit" data-index="5" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="button" id="verifyOtpBtn" onclick="verifyOtp()"
                                class="px-6 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Verify OTP
                            </button>
                            <button type="button" id="resendOtpBtn" onclick="sendOtp()" class="text-sm text-blue-600 font-semibold hover:underline hidden">
                                Resend OTP
                            </button>
                        </div>
                        <p id="otpMessage" class="text-xs mt-2 hidden"></p>
                    </div>
                </div>

                <!-- Email Verified Success (hidden initially) -->
                <div id="emailVerifiedBanner" class="hidden">
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                        <div class="verified-check flex-shrink-0 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-emerald-800">Email Verified Successfully!</p>
                            <p class="text-xs text-emerald-600" id="verifiedEmailText"></p>
                        </div>
                    </div>
                </div>

                <!-- Remaining fields (disabled until email verified) -->
                <div id="remainingFields" class="space-y-4 fields-disabled">
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Contact No</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="Enter 10 digit Number" maxlength="10">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Address</label>
                        <textarea name="address" required rows="2"
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="Your Full address">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Branch</label>
                        <select name="branch_id" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition bg-white">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Profile Photo</label>
                        <input type="file" name="image" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-bold text-slate-700 block mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                                placeholder="••••••••">
                        </div>
                        <div>
                            <label class="text-sm font-bold text-slate-700 block mb-2">Confirm</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" required
                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <label class="ml-2 text-sm text-slate-500">I agree to the <a href="#"
                                class="text-blue-600 font-bold hover:underline">Terms & Conditions</a></label>
                    </div>
                    <button type="submit" id="registerBtn"
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>Register
                        as Student</button>
                </div>
            </form>
            <div class="mt-8 pt-8 border-t text-center">
                <p class="text-sm text-slate-500">Already have an account? <a href="{{ route('student.login') }}?redirect_to={{ request('redirect_to') }}"
                        class="text-blue-600 font-bold hover:underline">Login here</a></p>
            </div>
        </div>
    </div>

    <script>
        let emailVerified = false;
        let otpTimerInterval = null;
        let otpTimeRemaining = 0;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // OTP digit inputs auto-focus behavior
        document.querySelectorAll('.otp-digit').forEach((input, index, inputs) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val;

                if (val) {
                    e.target.classList.add('filled');
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else {
                    e.target.classList.remove('filled');
                }

                // Enable verify button when all 6 digits entered
                const allFilled = Array.from(inputs).every(inp => inp.value.length === 1);
                document.getElementById('verifyOtpBtn').disabled = !allFilled;
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                    inputs[index - 1].classList.remove('filled');
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                pastedData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                        inputs[i].classList.add('filled');
                    }
                });
                if (pastedData.length === 6) {
                    inputs[5].focus();
                    document.getElementById('verifyOtpBtn').disabled = false;
                }
            });
        });

        function setEmailStatus(status, text) {
            const el = document.getElementById('emailStatus');
            el.className = 'email-status ' + status;

            const icons = {
                pending: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="5"/></svg>',
                sending: '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>',
                sent: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>',
                verified: '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>',
                error: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>'
            };

            el.innerHTML = (icons[status] || '') + ' ' + text;
        }

        function startOtpTimer(seconds) {
            otpTimeRemaining = seconds;
            const timerEl = document.getElementById('otpTimer');
            const resendBtn = document.getElementById('resendOtpBtn');
            resendBtn.classList.add('hidden');

            if (otpTimerInterval) clearInterval(otpTimerInterval);

            otpTimerInterval = setInterval(() => {
                otpTimeRemaining--;
                const mins = Math.floor(otpTimeRemaining / 60);
                const secs = otpTimeRemaining % 60;
                timerEl.textContent = `Expires in ${mins}:${secs.toString().padStart(2, '0')}`;

                if (otpTimeRemaining <= 0) {
                    clearInterval(otpTimerInterval);
                    timerEl.textContent = 'OTP Expired';
                    resendBtn.classList.remove('hidden');
                }
            }, 1000);
        }

        function showOtpMessage(message, isError = false) {
            const el = document.getElementById('otpMessage');
            el.textContent = message;
            el.className = `text-xs mt-2 font-medium ${isError ? 'text-red-600' : 'text-emerald-600'}`;
        }

        async function sendOtp() {
            const email = document.getElementById('emailInput').value.trim();
            if (!email || !email.includes('@')) {
                setEmailStatus('error', 'Invalid Email');
                return;
            }

            const btn = document.getElementById('sendOtpBtn');
            btn.disabled = true;
            btn.textContent = 'Sending...';
            btn.classList.remove('pulse-btn');
            setEmailStatus('sending', 'Sending OTP...');

            try {
                const response = await fetch('{{ route("student.register.send-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    setEmailStatus('sent', 'OTP Sent');
                    document.getElementById('otpSection').classList.add('active');
                    document.getElementById('emailInput').readOnly = true;
                    document.getElementById('emailInput').classList.add('bg-slate-50');
                    btn.textContent = 'OTP Sent';
                    startOtpTimer(600); // 10 minutes
                    // Focus first OTP input
                    setTimeout(() => document.querySelector('.otp-digit').focus(), 400);
                } else {
                    setEmailStatus('error', 'Failed');
                    btn.disabled = false;
                    btn.textContent = 'Send OTP';
                    btn.classList.add('pulse-btn');
                    showOtpMessage(data.message || 'Failed to send OTP. Please try again.', true);
                    // Show OTP section for error message display
                    document.getElementById('otpSection').classList.add('active');
                }
            } catch (error) {
                setEmailStatus('error', 'Error');
                btn.disabled = false;
                btn.textContent = 'Send OTP';
                btn.classList.add('pulse-btn');
                showOtpMessage('Network error. Please check your connection and try again.', true);
                document.getElementById('otpSection').classList.add('active');
            }
        }

        async function verifyOtp() {
            const email = document.getElementById('emailInput').value.trim();
            const otpInputs = document.querySelectorAll('.otp-digit');
            const otp = Array.from(otpInputs).map(i => i.value).join('');

            if (otp.length !== 6) return;

            const btn = document.getElementById('verifyOtpBtn');
            btn.disabled = true;
            btn.textContent = 'Verifying...';

            try {
                const response = await fetch('{{ route("student.register.verify-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        otp: otp
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    emailVerified = true;

                    // Stop timer
                    if (otpTimerInterval) clearInterval(otpTimerInterval);

                    // Update UI
                    setEmailStatus('verified', 'Verified');
                    document.getElementById('otpSection').classList.remove('active');
                    document.getElementById('emailVerifiedBanner').classList.remove('hidden');
                    document.getElementById('verifiedEmailText').textContent = email;

                    // Enable remaining fields and submit button
                    document.getElementById('remainingFields').classList.remove('fields-disabled');
                    document.getElementById('registerBtn').disabled = false;

                    // Focus the next field
                    setTimeout(() => {
                        const phoneInput = document.querySelector('input[name="phone"]');
                        if (phoneInput) phoneInput.focus();
                    }, 300);
                } else {
                    btn.disabled = false;
                    btn.textContent = 'Verify OTP';
                    showOtpMessage(data.message || 'Invalid OTP. Please try again.', true);

                    // Clear OTP inputs
                    otpInputs.forEach(input => {
                        input.value = '';
                        input.classList.remove('filled');
                    });
                    otpInputs[0].focus();
                }
            } catch (error) {
                btn.disabled = false;
                btn.textContent = 'Verify OTP';
                showOtpMessage('Network error. Please try again.', true);
            }
        }

        // Prevent form submission if email is not verified
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!emailVerified) {
                e.preventDefault();
                setEmailStatus('error', 'Not Verified');
                document.getElementById('sendOtpBtn').classList.add('pulse-btn');
                alert('Please verify your email address with OTP before registering.');
            }
        });
    </script>
</body>

</html>