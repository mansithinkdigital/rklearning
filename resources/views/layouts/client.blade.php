<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rk Institute - Transform Your Future')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('admin/asset/favicons/favicon.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #3730A3;
            --secondary: #0F172A;
            --text-dark: #1E293B;
            --text-light: #64748B;
            --bg-body: #FFFFFF;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        .top-bar {
            background-color: white;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            color: #64748b;
        }

        .navbar {
            background: white;
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 600;
            color: #1e293b;
            transition: color 0.3s ease;
            font-size: 15px;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .btn-join {
            background-color: var(--primary);
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            font-weight: 700;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-join:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        @yield('styles')
    </style>
</head>

<body class="antialiased">
    <!-- Top Bar -->
    <div class="top-bar py-3 hidden md:block">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-primary"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-primary"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-primary"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-primary"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span class="text-slate-300">|</span>
                <div class="flex items-center space-x-2">
                    <i class="fa fa-envelope text-primary"></i>
                    <span>Rkinstitute.cm@gmail.com</span>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <i class="fa fa-phone-alt text-primary"></i>
                    <span>+91 8888937680</span>
                </div>

            </div>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="navbar sticky top-0 z-50 py-2 border-b border-slate-50">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="{{ asset('assets/RK LOGO.png') }}" alt="Logo" class="h-20 w-auto mr-2">
            </a>
            <nav class="hidden lg:flex items-center space-x-10">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('about') }}" class="nav-link">About</a>
                <a href="{{ route('courses') }}" class="nav-link">Courses</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                <a href="{{ route('certificate.verify') }}" class="nav-link">Verify Certificate</a>
            </nav>

            <div class="flex items-center space-x-6">
                <button class="text-slate-400 hover:text-primary transition-colors">
                    <i class="fa fa-search text-xl"></i>
                </button>
                @auth
                <a href="{{ route('student.dashboard') }}" class="btn-join hidden md:block">
                    <i class="fa fa-th-large mr-2"></i> Dashboard
                </a>
                @else
                <a href="{{ route('student.login') }}" class="btn-join hidden md:block">
                    Join Now
                </a>
                @endauth
                <!-- Mobile toggle -->
                <button class="lg:hidden text-slate-900">
                    <i class="fa fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-slate-600 border-t border-slate-100">
        <div class="container mx-auto px-6 pt-20 pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
                <div class="lg:col-span-4">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('assets/RK LOGO.png') }}"
                            class="h-16 w-auto object-contain" alt="Rk Institute Logo">
                    </div>
                    <p class="mb-8 text-base leading-relaxed text-slate-500 max-w-sm">
                        Empowering learners worldwide through high-quality, project-based education. Join our community and start your journey today.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/rk_institute_1?igsh=dGtnMjkzNXg4bm53" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <h4 class="font-bold text-slate-900 mb-7 relative inline-block">
                        Explore
                        <span class="absolute -bottom-2 left-0 w-8 h-1 bg-indigo-600 rounded-full"></span>
                    </h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">About Us</a></li>
                        <li><a href="{{ route('courses') }}" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">All Courses</a></li>
                        <li><a href="{{ route('certificate.verify') }}" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Verify Certificate</a></li>
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Instructors</a></li>
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Latest News</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-bold text-slate-900 mb-7 relative inline-block">
                        Support
                        <span class="absolute -bottom-2 left-0 w-8 h-1 bg-indigo-600 rounded-full"></span>
                    </h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Help Center</a></li>
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-indigo-600 hover:translate-x-1 transition-all inline-block">Community</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-4">
                    <h4 class="font-bold text-slate-900 mb-7 relative inline-block">
                        Get in Touch
                        <span class="absolute -bottom-2 left-0 w-8 h-1 bg-indigo-600 rounded-full"></span>
                    </h4>
                    <div class="bg-slate-50 rounded-3xl p-6 space-y-5">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 shrink-0 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa fa-map-marker-alt text-indigo-600"></i>
                            </div>
                            <span class="text-sm leading-relaxed">Near Maharashtra Book House, Lonar Lane, Ashok Stambha, RK, Nashik</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 shrink-0 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa fa-phone-alt text-indigo-600"></i>
                            </div>
                            <span class="text-sm font-medium">+91 8888937680</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 shrink-0 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa fa-envelope text-indigo-600"></i>
                            </div>
                            <span class="text-sm font-medium text-indigo-600">Rkinstitute.cm@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center text-sm font-medium">
                <p class="text-slate-400">
                    &copy; {{ date('Y') }} <span class="text-slate-900">Rk Institute</span>. All rights reserved.
                </p>

                <div class="mt-4 md:mt-0 px-6 py-2 bg-slate-50 rounded-full">
                    <span class="text-slate-400">Handcrafted by</span>
                    <a href="https://thinkdigital.com" target="_blank"
                        class="text-indigo-600 hover:text-indigo-800 transition ml-1">
                        ThinkDigital
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>