<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard') - RK Learning Hub</title>
    <!-- Scripts & Styles -->
    <link rel="icon" type="image/png" href="{{ asset('admin/asset/favicons/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #F1F5F9;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            /* 🔥 increase space here */
            padding: 0.875rem 1.25rem;
            color: #64748B;
            border-radius: 0.75rem;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
        }

        .sidebar-link:hover {
            background-color: #E2E8F0;
            color: #1E293B;
        }

        .sidebar-link.active {
            background-color: #1D4ED8;
            color: white;
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.2);
        }

        .sidebar-link i {
            margin-right: 0.875rem;
            width: 1.25rem;
            height: 1.25rem;
        }

        .main-content {
            margin-left: 280px;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            z-index: 50;
            overflow-y: auto;
            padding: 1.5rem;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Sidebar toggle animation */
        .sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card {
            background: white;
            border-radius: 1.5rem;
            border: 1px solid #E2E8F0;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .btn-logout {
            color: #EF4444;
        }

        .btn-logout:hover {
            background-color: #FEF2F2;
        }
    </style>
</head>

<body class="antialiased font-['Outfit']">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="student-sidebar" class="sidebar border-r border-slate-100">
            <div class="mb-10 flex items-center px-2">
                <img src="{{ asset('admin/asset/logo/rk_logo.webp') }}" alt="Logo" class="h-10 mr-3">
            </div>

            <nav>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 px-2">Menu</p>
                <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-grid"></i>
                    <span>Dashboard</span>
                </a>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-8 mb-4 px-2">Academic</p>
                <a href="{{ route('student.my-courses') }}" class="sidebar-link {{ request()->routeIs('student.my-courses') ? 'active' : '' }}">
                    <i data-lucide="play-circle"></i>
                    <span>My Courses</span>
                </a>
                <a href="{{ route('student.exams') }}" class="sidebar-link {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                    <i data-lucide="file-text"></i>
                    <span>Exam Portal</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="award"></i>
                    <span>Certificates</span>
                </a>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-8 mb-4 px-2">Administrative</p>
                <a href="{{ route('student.financials') }}" class="sidebar-link {{ request()->routeIs('student.financials') ? 'active' : '' }}">
                    <i data-lucide="credit-card"></i>
                    <span>Fee History</span>
                </a>
                <a href="{{ route('student.study-material') }}" class="sidebar-link {{ request()->routeIs('student.study-material') ? 'active' : '' }}">
                    <i data-lucide="file-down"></i>
                    <span>Study Material</span>
                </a>
                <a href="{{ route('student.free-videos') }}" class="sidebar-link {{ request()->routeIs('student.free-videos') ? 'active' : '' }}">
                    <i data-lucide="video"></i>
                    <span>Free Videos</span>
                </a>
                <a href="{{ route('student.free-pdfs') }}" class="sidebar-link {{ request()->routeIs('student.free-pdfs') ? 'active' : '' }}">
                    <i data-lucide="file-text"></i>
                    <span>Free PDFs</span>
                </a>

                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-8 mb-4 px-2">Account</p>
                <a href="{{ route('student.profile') }}" class="sidebar-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i data-lucide="user"></i>
                    <span>Profile Settings</span>
                </a>
                <div class="mt-9 border-t border-slate-100 pt-3">
                    <form action="{{ route('student.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left btn-logout">
                            <i data-lucide="log-out"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md sticky top-0 flex items-center justify-between px-6 lg:px-10 z-40 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-100 transition">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">@yield('title')</h2>
                        <p class="text-sm text-slate-500 hidden sm:block">Welcome back, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </button>
                    <div class="flex items-center space-x-3 pl-4 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-900 leading-none mb-1">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 uppercase font-medium">{{ auth()->user()->role }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            <!-- Content Area -->
            <div class="p-4 sm:p-6 lg:p-10 overflow-x-hidden">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        // Sidebar Toggle Logic
        const sidebar = document.getElementById('student-sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity duration-300 opacity-0';
        document.body.appendChild(backdrop);

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('hidden');
            setTimeout(() => backdrop.classList.toggle('opacity-100'), 10);
            document.body.classList.toggle('overflow-hidden');
        }

        toggleBtn?.addEventListener('click', toggleSidebar);
        backdrop.addEventListener('click', toggleSidebar);

        // Close sidebar on small screen link clicks
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024 && sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });
        });
    </script>
    @yield('scripts')
</body>

</html>