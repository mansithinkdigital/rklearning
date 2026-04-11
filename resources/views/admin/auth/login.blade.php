<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - RK Learning Hub</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('admin/asset/favicons/favicon.png') }}">

    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            background-image:
                radial-gradient(at 0% 0%, rgba(30, 64, 175, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(30, 64, 175, 0.15) 0px, transparent 50%);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 antialiased">
    <div class="w-full max-w-[440px] relative z-10">


        <!-- Login Form -->
        <div class="glass-panel rounded-[2rem] p-8 md:p-10">
            <!-- Logo Area -->
            <div class="flex justify-center mb-5">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative bg-white p-5 rounded-3xl shadow-2xl">
                        <img src="{{ asset('admin/asset/logo/rk_logo.webp') }}" alt="RK Logo" class="h-16 w-auto object-contain">
                    </div>
                </div>
            </div>
            <div class="text-center mb-5">
                <h2 class="text-2xl font-bold text-white mb-2">Admin Portal</h2>
                <p class="text-slate-400 text-sm font-medium">Sign in to access the dashboard</p>
            </div>

            @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm font-bold mb-8 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 pl-1">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                        <input type="email" name="email" required
                            class="input-field w-full pl-12 pr-4 py-4 rounded-2xl text-sm font-semibold placeholder:text-slate-600"
                            placeholder="admin@rklearning.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest pl-1">Password</label>
                        <a href="#" class="text-[11px] font-bold text-blue-500 hover:text-blue-400 uppercase tracking-wider">Forgot?</a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                        <input type="password" name="password" required
                            class="input-field w-full pl-12 pr-4 py-4 rounded-2xl text-sm font-semibold placeholder:text-slate-600"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center gap-3 pl-1">
                    <input type="checkbox" id="remember" class="w-5 h-5 rounded-lg border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-600/20">
                    <label for="remember" class="text-sm font-bold text-slate-400 cursor-pointer">Stay logged in</label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-extrabold py-5 rounded-2xl transition-all shadow-xl shadow-blue-600/20 flex items-center justify-center gap-3 group">
                    <span>SIGN IN</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-slate-600 text-[10px] font-bold mt-10 uppercase tracking-[0.2em]">
            &copy; 2026 Ramesh Kolhe's Learning Hub &bull; Secured System
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>