<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - RK Learning Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-blue-50 to-indigo-100">
<<<<<<< HEAD
    <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 glass-card shadow-2xl overflow-hidden">
        <!-- Decoration -->
        <div class="hidden md:flex bg-blue-600 p-12 flex-col justify-between text-white relative">
            <div class="relative z-10">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-12 invert brightness-0 mb-8">
=======
    <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 glass-card shadow-2xl overflow-hidden">
        <!-- Decoration -->
        <div class="hidden md:flex bg-blue-600 p-12 flex-col justify-between text-white relative">
            <div class="relative z-10">
                <img src="{{ asset('admin/asset/logo/rk_logo.webp') }}" class="h-12 mb-8 w-[350px] object-contain">
>>>>>>> 8c5dbd7a9ba4f423361af4cf1d17a4c05ca57307
                <h2 class="text-4xl font-bold mb-6">Join the RK Learning Community</h2>
                <p class="text-blue-100 text-lg">Start your journey from Classroom to Cloud today. Get access to premium
                    courses and expert mentorship.</p>
            </div>
<<<<<<< HEAD

            <div class="relative z-10 flex items-center space-x-4">
                <div class="flex -space-x-3">
                    <img class="w-10 h-10 rounded-full border-2 border-blue-600"
                        src="https://ui-avatars.com/api/?name=Stu+1&background=random">
                    <img class="w-10 h-10 rounded-full border-2 border-blue-600"
                        src="https://ui-avatars.com/api/?name=Stu+2&background=random">
                    <img class="w-10 h-10 rounded-full border-2 border-blue-600"
                        src="https://ui-avatars.com/api/?name=Stu+3&background=random">
                </div>
                <p class="text-sm font-medium">10k+ Students joined</p>
            </div>

            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        </div>

=======
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        </div>
>>>>>>> 8c5dbd7a9ba4f423361af4cf1d17a4c05ca57307
        <!-- Form -->
        <div class="p-8 md:p-12 bg-white">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Create Account</h3>
                <p class="text-slate-500">Sign up for your free student account.</p>
            </div>
<<<<<<< HEAD

=======
>>>>>>> 8c5dbd7a9ba4f423361af4cf1d17a4c05ca57307
            <form action="{{ route('student.register.submit') }}" method="POST" class="space-y-4">
                @csrf

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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="name@example.com">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Contact No</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                            placeholder="Enter 10 digit Number" maxlength="10">
                    </div>
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
<<<<<<< HEAD
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>

=======
                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>
>>>>>>> 8c5dbd7a9ba4f423361af4cf1d17a4c05ca57307
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
<<<<<<< HEAD

=======
>>>>>>> 8c5dbd7a9ba4f423361af4cf1d17a4c05ca57307
                <div class="flex items-center">
                    <input type="checkbox" required
                        class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label class="ml-2 text-sm text-slate-500">I agree to the <a href="#"
                            class="text-blue-600 font-bold hover:underline">Terms & Conditions</a></label>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">Register
                    as Student</button>
            </form>
            <div class="mt-8 pt-8 border-t text-center">
                <p class="text-sm text-slate-500">Already have an account? <a href="{{ route('student.login') }}"
                        class="text-blue-600 font-bold hover:underline">Login here</a></p>
            </div>
        </div>
    </div>
</body>

</html>