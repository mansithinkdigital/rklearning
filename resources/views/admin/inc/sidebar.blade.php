<aside id="sidebar"
    class="fixed left-0 top-0 h-screen w-64 bg-white dark:bg-[#0b1120]
    border-r border-[#f1f5f9] dark:border-[#1e293b]
    transition-all duration-300 z-50 overflow-y-auto
    -translate-x-full lg:translate-x-0   <!-- ✅ ADD THIS -->
    group-[.sidebar-collapsed]:w-20">
    <div class="px-5 py-8 h-full flex flex-col">
        <!-- Logo Branding -->
        </a>
        <div class="flex items-center justify-center mb-8 px-2">
            <a href="{{ route('admin.dashboard') }}">
                <img
                    src="{{ asset('admin/asset/logo/rk_logo.webp') }}"
                    alt="Logo"
                    class="w-30 md:w-34 h-auto object-contain transition-all duration-300
               group-[.sidebar-collapsed]:w-12">
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-grow space-y-7">
            <!-- Console -->
            <div>
                <p class="text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-3 px-2 group-[.sidebar-collapsed]:hidden">MAIN</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="layout-dashboard" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.branch.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/branch*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="map-pin" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Branch</span>
                    </a>
                </div>
            </div>

            <!-- Site Management -->
            <div>
                <p class="text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2 group-[.sidebar-collapsed]:hidden">COURSES MANAGEMENT</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.course.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/course') || request()->is('admin/course/*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="book-open" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Our Course</span>
                    </a>
                    <a href="{{ route('admin.subject.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/subject*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="layers" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Course Subjects</span>
                    </a>
                    <a href="{{ route('admin.package.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/package*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="package" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Packages</span>
                    </a>
                    <a href="{{ route('admin.course-package.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/course-package*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="archive" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Course Package</span>
                    </a>
                    <a href="{{ route('admin.free-pdf.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/free-pdf*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="file-text" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Free PDF List</span>
                    </a>
                    <a href="{{ route('admin.free-video.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/free-video*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="video" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Free Video List</span>
                    </a>
                    <a href="{{ route('admin.course-subject.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/course-subject*') || request()->is('admin/course-mcq*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="help-circle" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Manage MCQs</span>
                    </a>
                </div>
            </div>

            <!-- Academic & Governance -->
            <div>
                <p class="text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2 group-[.sidebar-collapsed]:hidden">Paid Content</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.paid-video.index') }}" 
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/paid-video*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="video" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Paid Video List</span>
                    </a>
                    <!-- <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-[#64748b] dark:text-[#94a3b8] rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                        <i data-lucide="graduation-cap" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Academic Hub</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-[#64748b] dark:text-[#94a3b8] rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                        <i data-lucide="user-plus" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Admissions</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-[#64748b] dark:text-[#94a3b8] rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                        <i data-lucide="info" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Compliance & Cells</span>
                    </a> -->
                </div>
            </div>

            <!-- Media -->
            <div>
                <p class="text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2 group-[.sidebar-collapsed]:hidden">MEDIA</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.gallery.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/gallery*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="image" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Gallery</span>
                    </a>
                </div>
            </div>

            <!-- System -->
            <div>
                <p class="text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2 group-[.sidebar-collapsed]:hidden">SYSTEM</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.vacancy.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/vacancy*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <i data-lucide="briefcase" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Vacancies</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-[#64748b] dark:text-[#94a3b8] rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                        <i data-lucide="settings" class="w-[18px] h-[18px]"></i>
                        <span class="text-[13px] font-bold group-[.sidebar-collapsed]:hidden">Site Settings</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Bottom Sign Out -->
        <div class="mt-auto pt-6">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-2 py-2 text-[#ff3b3b] font-black uppercase tracking-[0.15em] text-[11px] group">
                    <i data-lucide="log-out" class="w-5 h-5 transition-transform group-hover:-translate-x-1"></i>
                    <span class="group-[.sidebar-collapsed]:hidden">SIGN OUT</span>
                </button>
            </form>
        </div>
    </div>
</aside>