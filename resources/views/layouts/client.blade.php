<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rk Learning Hub - Transform Your Future')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style>
        :root {
            --primary: #1D4ED8;
            --primary-light: #3B82F6;
            --secondary: #0F172A;
            --accent: #FBBF24;
            --text-dark: #1E293B;
            --text-light: #64748B;
            --bg-body: #F8FAFC;
            --white: #FFFFFF;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        /* Navbar Styling */
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .nav-link {
            position: relative;
            font-weight: 500;
            color: var(--text-dark);
            transition: color 0.3s ease;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(29, 78, 216, 0.39);
        }

        .btn-primary:hover {
            background-color: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(29, 78, 216, 0.23);
        }

        /* Footer */
        footer {
            background-color: var(--secondary);
            color: white;
        }

        .footer-link {
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--accent);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease forwards;
        }

        @yield('styles')
    </style>
</head>
<body class="antialiased">
    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-50 py-4">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="text-xl font-bold text-slate-900 Outfit">Rk Learning Hub</span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('about') }}" class="nav-link">About Us</a>
                <a href="{{ route('courses') }}" class="nav-link">Courses</a>
                <a href="#" class="nav-link">Trainers</a>
                <a href="#" class="nav-link">Blogs</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact Us</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 font-medium hover:text-primary transition">Login</a>
                    <a href="{{ route('student.register') }}" class="btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center space-x-2 mb-6">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto invert brightness-0">
                        <span class="text-xl font-bold text-white Outfit">Rk Learning Hub</span>
                    </div>
                    <p class="text-slate-400 mb-6 italic">
                        Empowering learners worldwide through innovative and accessible online education.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 Outfit">Quick Links</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                        <li><a href="{{ route('about') }}" class="footer-link">About Us</a></li>
                        <li><a href="#" class="footer-link">Our Trainers</a></li>
                        <li><a href="#" class="footer-link">Latest Blogs</a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 Outfit">Popular Courses</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('courses') }}" class="footer-link">Web Development</a></li>
                        <li><a href="{{ route('courses') }}" class="footer-link">UI/UX Design</a></li>
                        <li><a href="{{ route('courses') }}" class="footer-link">Data Science</a></li>
                        <li><a href="{{ route('courses') }}" class="footer-link">Digital Marketing</a></li>
                        <li><a href="{{ route('courses') }}" class="footer-link">Graphic Design</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 Outfit">Get In Touch</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <i class="fa fa-location-dot mt-1.5 text-primary"></i>
                            <span class="text-slate-400">123 Learning Lane, Knowledge City, EDU 456</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa fa-phone text-primary"></i>
                            <span class="text-slate-400">+1 234 567 8900</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa fa-envelope text-primary"></i>
                            <span class="text-slate-400">contact@rk-learning.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-slate-800 mb-8">
            <div class="text-center text-slate-500 text-sm">
                <p>&copy; {{ date('Y') }} Rk Learning Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
