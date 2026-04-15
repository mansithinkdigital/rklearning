<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rk Learning Hub - Transform Your Future')</title>

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

        footer {
            background-color: #111827;
            color: #94a3b8;
            padding-top: 80px;
            padding-bottom: 40px;
        }

        .footer-title {
            color: white;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .footer-link {
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 12px;
        }

        .footer-link:hover {
            color: white;
            padding-left: 5px;
        }

        .social-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: var(--primary);
            transform: translateY(-3px);
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
                    <span>info@zilom.com</span>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <i class="fa fa-phone-alt text-primary"></i>
                    <span>+91 (234) 567 890</span>
                </div>

            </div>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="navbar sticky top-0 z-50 py-5 border-b border-slate-50">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="{{ asset('admin/asset/logo/rk_logo.webp') }}" alt="Logo" class="h-10 w-auto mr-2">
            </a>

            <nav class="hidden lg:flex items-center space-x-10">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('courses') }}" class="nav-link">Courses</a>
                <a href="{{ route('about') }}" class="nav-link">Pages</a>
                <a href="#" class="nav-link">Blog</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact Us</a>
            </nav>

            <div class="flex items-center space-x-6">
                <button class="text-slate-400 hover:text-primary transition-colors">
                    <i class="fa fa-search text-xl"></i>
                </button>
                <a href="{{ route('student.register') }}" class="btn-join hidden md:block">
                    Join Now
                </a>
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
    <footer>
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div>
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('admin/asset/logo/rk_logo.webp') }}"
                            class="h-10 w-auto mr-2 brightness-0 invert">
                    </div>
                    <p class="mb-8 text-sm leading-relaxed">
                        There are many variations of passages of available but the majority have suffered alteration in
                        some form.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="footer-title">Quick Links</h4>
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Courses</a>
                    <a href="#" class="footer-link">Instructors</a>
                    <a href="#" class="footer-link">Latest News</a>
                    <a href="#" class="footer-link">Contact Us</a>
                </div>

                <div>
                    <h4 class="footer-title">Support</h4>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Terms & Conditions</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">FAQs</a>
                    <a href="#" class="footer-link">Community</a>
                </div>

                <div>
                    <h4 class="footer-title">Contact Us</h4>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start space-x-3">
                            <i class="fa fa-map-marker-alt mt-1 text-primary"></i>
                            <span>25/B, Knowledge City, New York, USA</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fa fa-phone-alt text-primary"></i>
                            <span>+1 (234) 567 890</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fa fa-envelope text-primary"></i>
                            <span>info@zilom.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs">
                <p>&copy; {{ date('Y') }} Zilom. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>