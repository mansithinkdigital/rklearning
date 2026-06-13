<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | RK Institute</title>

    <link rel="icon" type="image/png" href="{{ asset('admin/asset/favicons/favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- ✅ jQuery (MUST be first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ✅ Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- ✅ Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    },
                }
            }
        }
    </script>

    <style type="text/css">
        body {
            @apply transition-colors duration-300 antialiased overflow-x-hidden;
        }

        /* Fixed structural logic to prevent content from hiding below sidebar */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: all 0.3s ease-in-out;
        }

        @media (min-width: 1024px) {
            .main-container.sidebar-expanded {
                padding-left: 256px;
                /* 64 * 4px */
            }

            .main-container.sidebar-collapsed {
                padding-left: 80px;
                /* 20 * 4px */
            }
        }

        /* Sidebar collapsed state */
        #sidebar.sidebar-collapsed {
            width: 80px !important;
        }

        #sidebar.sidebar-collapsed .sidebar-text {
            display: none !important;
        }

        #sidebar.sidebar-collapsed .sidebar-label {
            display: none !important;
        }

        #sidebar.sidebar-collapsed .sidebar-full-logo {
            display: none !important;
        }

        #sidebar.sidebar-collapsed .sidebar-mini-logo {
            display: block !important;
            width: 56px !important;
            height: 56px !important;
            object-fit: contain;
            margin: 0 auto;
        }

        #sidebar.sidebar-collapsed .sidebar-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 16px;
            height: 16px;
            font-size: 9px;
        }

        #sidebar.sidebar-collapsed .sidebar-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        #sidebar.sidebar-collapsed nav>div {
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        #sidebar.sidebar-collapsed nav>div:last-child {
            border-bottom: none;
        }

        /* Tooltip on hover for collapsed sidebar */
        #sidebar.sidebar-collapsed .sidebar-link {
            position: relative;
        }

        #sidebar.sidebar-collapsed .sidebar-link:hover::after {
            content: attr(title);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            z-index: 999;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #sidebar.sidebar-collapsed .sidebar-link:hover::before {
            content: '';
            position: absolute;
            left: calc(100% + 4px);
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #1e293b;
            z-index: 999;
            pointer-events: none;
        }

        /* Summernote List Fix */
        .note-editable ul {
            list-style-type: disc !important;
            padding-left: 20px !important;
            margin: 10px 0 !important;
        }

        .note-editable ol {
            list-style-type: decimal !important;
            padding-left: 20px !important;
            margin: 10px 0 !important;
        }

        .note-editable li {
            display: list-item !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#f8fafc] dark:bg-[#020617] text-slate-900 dark:text-slate-100 group">
    @include('admin.inc.sidebar')

    <!-- Structural Wrapper -->
    <div id="content-wrapper" class="main-container sidebar-expanded min-h-screen transition-all duration-300 ease-in-out">
        @include('admin.inc.header')

        <main class="flex-grow p-4 md:p-8 lg:p-12">
            @yield('content')
        </main>

        <footer class="p-10 text-center border-t border-slate-100 dark:border-slate-900">
            <p class="text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.4em]">RK Institute &bull; POWERED BY GOVERNANCE V2.0 &bull; &copy; 2026</p>
        </footer>
    </div>
    <script>
        lucide.createIcons();
        // Theme Toggle
        const html = document.documentElement;
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');

        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);

        themeToggle?.addEventListener('click', () => {
            const currentTheme = html.classList.contains('dark') ? 'light' : 'dark';
            setTheme(currentTheme);
        });

        function setTheme(theme) {
            if (theme === 'dark') {
                html.classList.add('dark');
                sunIcon?.classList.remove('hidden');
                moonIcon?.classList.add('hidden');
            } else {
                html.classList.remove('dark');
                sunIcon?.classList.add('hidden');
                moonIcon?.classList.remove('hidden');
            }
            localStorage.setItem('theme', theme);
        }

        // Professional Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.getElementById('content-wrapper');
        const toggleBtn = document.getElementById('toggle-sidebar-button');

        // Load initial state
        const isCollapsed = localStorage.getItem('sidebar-state') === 'collapsed';
        if (isCollapsed && window.innerWidth > 1024) {
            applyMiniSidebar();
        }

        toggleBtn?.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('-translate-x-full');
            } else {
                if (contentWrapper.classList.contains('sidebar-expanded')) {
                    applyMiniSidebar();
                } else {
                    applyFullSidebar();
                }
            }
        });

        function applyMiniSidebar() {
            contentWrapper.classList.remove('sidebar-expanded');
            contentWrapper.classList.add('sidebar-collapsed');
            sidebar.classList.add('sidebar-collapsed');
            localStorage.setItem('sidebar-state', 'collapsed');
        }

        function applyFullSidebar() {
            contentWrapper.classList.remove('sidebar-collapsed');
            contentWrapper.classList.add('sidebar-expanded');
            sidebar.classList.remove('sidebar-collapsed');
            localStorage.setItem('sidebar-state', 'expanded');
        }

        // Close sidebar on mobile link click
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>