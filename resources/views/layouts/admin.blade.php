<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - RK Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar-link {
            display: flex;
            items-center: center;
            padding: 0.75rem 1rem;
            color: #475569;
            border-radius: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .sidebar-link.active {
            background-color: #e2e8f0;
            color: #1e293b;
            font-weight: 500;
        }

        .sidebar-link i {
            margin-right: 0.75rem;
            width: 20px;
            height: 20px;
        }

        .main-content {
            margin-left: 260px;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid #e2e8f0;
            background: white;
            z-index: 50;
            overflow-y: auto;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="px-6 py-8">
            <div class="flex flex-col items-center mb-10">
                <img src="{{ asset('assets/RK LOGO.png') }}" alt="Logo" class="h-24 mb-2">
                <p class="text-xs text-orange-600 font-semibold tracking-widest uppercase">Way to success</p>
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i data-lucide="book-open"></i>
                    <span>Home</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Student Registered</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Course Purchased</span>
                </a>
                <hr class="my-4 border-gray-100">
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Our courses</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Our subject</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Student Marks</span>
                </a>
                <hr class="my-4 border-gray-100">
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Free PDF</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Free Video</span>
                </a>
                <hr class="my-4 border-gray-100">
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Add Paid Video</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>View Paid Video</span>
                </a>
                <hr class="my-4 border-gray-100">
                <a href="#" class="sidebar-link">
                    <i data-lucide="book-open"></i>
                    <span>Test Series</span>
                </a>
                <div class="mt-8 pt-4 border-t border-gray-100">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left text-red-600 hover:bg-red-50">
                            <i data-lucide="log-out"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Header & Main Content -->
    <main class="main-content min-h-screen">
        <header class="h-16 bg-white border-b border-gray-200 sticky top-0 flex items-center justify-between px-8 z-40">
            <h2 class="text-xl font-semibold text-gray-800 uppercase tracking-tight">@yield('title')</h2>
            <div class="flex items-center space-gap-4">
                <span class="text-sm font-medium text-gray-600">{{ auth()->user()->email }}</span>
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->email, 0, 1)) }}
                </div>
            </div>
        </header>
        <div class="p-8">
            @yield('content')
        </div>
    </main>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>