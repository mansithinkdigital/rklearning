<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Rk Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            <h2 class="text-3xl font-bold text-slate-800">Verify OTP</h2>
            <p class="text-slate-500 mt-2">Enter the OTP sent to your email.</p>
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
        <form action="{{ route('student.password.verify-otp.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="text-sm font-bold text-slate-700 block mb-2 px-1">OTP</label>
                <input type="text" name="otp" required class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-center tracking-widest text-lg" placeholder="••••••" maxlength="6">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 mt-4">Verify OTP</button>
        </form>
    </div>
</body>

</html>
