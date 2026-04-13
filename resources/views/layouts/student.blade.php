<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard') - RK Learning Hub</title>
    
    <!-- Scripts & Styles -->
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
        .sidebar-link i { margin-right: 0.875rem; width: 1.25rem; height: 1.25rem; }
        .main-content { margin-left: 280px; }
        .sidebar { width: 280px; height: 100vh; position: fixed; left: 0; top: 0; background: white; z-index: 50; overflow-y: auto; padding: 1.5rem; }
        
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
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
<body class="antialiased">
    <!-- Sidebar -->
    <aside class="sidebar border-r border-slate-100">
        <div class="mb-10 flex items-center px-2">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 mr-3">
            <span class="text-xl font-bold text-slate-900">Student Portal</span>
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

            <a href="#" class="sidebar-link">
                <i data-lucide="file-down"></i>
                <span>Study Material</span>
            </a>
            
            <a href="#" class="sidebar-link">
                <i data-lucide="youtube"></i>
                <span>Free Videos</span>
            </a>

            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-8 mb-4 px-2">Account</p>

            <a href="{{ route('student.profile') }}" class="sidebar-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                <i data-lucide="user"></i>
                <span>Profile Settings</span>
            </a>

            <div class="mt-10 border-t border-slate-100 pt-4">
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
    <main class="main-content">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md sticky top-0 flex items-center justify-between px-10 z-40 border-b border-slate-100">
            <div>
                <h2 class="text-xl font-bold text-slate-800">@yield('title')</h2>
                <p class="text-sm text-slate-500">Welcome back, {{ auth()->user()->name }}!</p>
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
        <div class="p-10">
            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
