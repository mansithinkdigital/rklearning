<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - Rk Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Scripts & Styles -->
    <link rel="icon" type="image/png" href="{{ asset('admin/asset/favicons/favicon.png') }}">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-indigo-50 to-blue-100">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl p-10 md:p-12 border border-blue-50">
        <div class="text-center mb-10">
            <img src="{{ asset('assets/RK LOGO.png') }}" class="mx-auto mb-6" style="width: 300px;height: 80px">
            <h2 class="text-3xl font-bold text-slate-800">Student Login</h2>
            <p class="text-slate-500 mt-2">Welcome back! Please enter your details.</p>
        </div>
        @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-600 text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 text-red-600 text-sm font-medium">
            {{ $errors->first() }}
        </div>
        @endif
        <form action="{{ route('student.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
            <div>
                <label class="text-sm font-bold text-slate-700 block mb-2 px-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all" placeholder="name@example.com">
            </div>
            <div>
                <div class="flex items-center justify-between mb-2 px-1">
                    <label class="text-sm font-bold text-slate-700">Password</label>
                </div>
                <input type="password" name="password" required class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all" placeholder="••••••••">
                <div class="flex justify-end mt-2">
                    <a href="{{ route('student.password.request') }}" class="text-xs font-bold text-blue-600 hover:underline">Forgot Password?</a>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 mt-4">Sign In</button>
        </form>
        <div class="mt-10 text-center">
            <p class="text-sm text-slate-500">Don't have an account? <a href="{{ route('student.register') }}?redirect_to={{ request('redirect_to') }}" class="text-blue-600 font-bold hover:underline">Register Now</a></p>
        </div>
    </div>
</body>

</html>