<header class="h-20 bg-[#f8fafc] dark:bg-[#020617] transition-all duration-300">
    <div class="h-full px-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button id="toggle-sidebar-button" class="p-2 text-[#94a3b8] hover:text-slate-900 dark:hover:text-white transition-colors">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <div class="hidden sm:block h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-2"></div>
            <div class="hidden sm:flex flex-col">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Navigation</span>
                <span class="text-sm font-bold text-slate-900 dark:text-white">Admin Portal</span>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="p-2.5 rounded-xl bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i data-lucide="sun" id="sun-icon" class="w-5 h-5 hidden"></i>
                <i data-lucide="moon" id="moon-icon" class="w-5 h-5"></i>
            </button>

            <!-- User Profile -->
            <div class="flex items-center gap-4 pl-6 border-l border-slate-200 dark:border-slate-800">
                <div class="text-right hidden sm:block">
                    <p class="text-[13px] font-extrabold text-[#111827] dark:text-white leading-none mb-1">Admin User</p>
                    <p class="text-[11px] font-bold text-[#94a3b8] leading-none uppercase tracking-tighter">Super Admin</p>
                </div>
                <div class="relative cursor-pointer group" id="user-menu-button">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=cbd5e1&color=475569&bold=true" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white dark:border-slate-800 shadow-sm transition-transform group-hover:scale-105">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-[#f8fafc] dark:border-[#020617] rounded-full"></div>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#0f172a] rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 hidden z-50 transition-all duration-200 opacity-0 transform scale-95">
                        <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 mb-2">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Account</p>
                        </div>
                        <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>Profile</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <i data-lucide="settings" class="w-4 h-4"></i>
                            <span>Settings</span>
                        </a>
                        <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                <span class="font-bold">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const button = document.getElementById('user-menu-button');
                        const dropdown = document.getElementById('user-dropdown');
                        button.addEventListener('click', (e) => {
                            e.stopPropagation();
                            dropdown.classList.toggle('hidden');
                            setTimeout(() => {
                                dropdown.classList.toggle('opacity-0');
                                dropdown.classList.toggle('scale-95');
                            }, 10);
                        });
                        document.addEventListener('click', (e) => {
                            if (!button.contains(e.target)) {
                                dropdown.classList.add('hidden', 'opacity-0', 'scale-95');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</header>