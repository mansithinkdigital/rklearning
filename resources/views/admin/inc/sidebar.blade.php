<aside id="sidebar"
    class="group fixed left-0 top-0 h-screen bg-white dark:bg-[#0b1120]
    border-r border-[#f1f5f9] dark:border-[#1e293b]
    transition-all duration-300 z-50 overflow-y-auto overflow-x-hidden
    -translate-x-full lg:translate-x-0
    w-64 [&.sidebar-collapsed]:w-20">
    <div class="px-5 py-8 h-full flex flex-col">
        <!-- Logo Branding -->
        <div class="flex items-center justify-center mb-8 px-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center">
                <!-- Full Logo (shown when expanded) -->
                <img
                    src="{{ asset('assets/RK LOGO.png') }}"
                    alt="Logo"
                    class="w-40 md:w-44 h-auto object-contain transition-all duration-300
                    sidebar-full-logo">
                <!-- Small Logo (shown when collapsed) -->
                <!-- Small Logo (shown when collapsed) -->
                <img
                    src="{{ asset('assets/RK LOGO.png') }}"
                    alt="Logo"
                    class="sidebar-mini-logo hidden w-12 h-12 object-contain mx-auto">
            </a>
        </div>
        <!-- Navigation Menu -->
        <nav class="flex-grow space-y-7">
            <!-- Main -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-3 px-2">MAIN</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Dashboard">
                        <i data-lucide="layout-dashboard" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.branch.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/branch*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Branch">
                        <i data-lucide="map-pin" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Branch</span>
                    </a>
                </div>
            </div>
            <!-- User Management -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-3 px-2">USER MANAGEMENT</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.student.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/student*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Students Register">
                        <i data-lucide="users" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Students Register</span>
                    </a>
                </div>
            </div>

            <!-- Academic -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-3 px-2">ACADEMIC</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.exam-results.index') }}"
                        class="sidebar-link relative flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/exam-results*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Exam Results">
                        <div class="flex items-center gap-3">
                            <i data-lucide="award" class="w-[18px] h-[18px] flex-shrink-0"></i>
                            <span class="sidebar-text text-[13px] font-bold">Exam Results</span>
                        </div>
                        @if($reattemptRequestsCount > 0)
                        <span class="flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-[10px] font-black text-white animate-pulse sidebar-badge">
                            {{ $reattemptRequestsCount }}
                        </span>
                        @endif
                    </a>
                </div>
            </div>
            <!-- Financials -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-3 px-2">FINANCIALS</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.payments.online') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/payments/online*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Online Payments">
                        <i data-lucide="credit-card" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Online Payments</span>
                    </a>
                    <a href="{{ route('admin.payments.offline') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/payments/offline*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Offline Payments">
                        <i data-lucide="wallet" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Offline Payments</span>
                    </a>
                </div>
            </div>

            <!-- Site Management -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2">COURSES MANAGEMENT</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.course.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/course') || request()->is('admin/course/*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Our Course">
                        <i data-lucide="book-open" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Our Course</span>
                    </a>
                    <a href="{{ route('admin.subject.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/subject*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Course Subjects">
                        <i data-lucide="layers" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Course Subjects</span>
                    </a>
                    <a href="{{ route('admin.free-pdf.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/free-pdf*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Free PDF List">
                        <i data-lucide="file-text" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Free PDF List</span>
                    </a>
                    <a href="{{ route('admin.free-video.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/free-video*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Free Video List">
                        <i data-lucide="video" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Free Video List</span>
                    </a>
                    <a href="{{ route('admin.course-subject.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/course-subject*') || request()->is('admin/course-mcq*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Manage MCQs">
                        <i data-lucide="help-circle" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Manage MCQs</span>
                    </a>
                </div>
            </div>


            <!-- Media -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2">MEDIA</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.gallery.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/gallery*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Gallery">
                        <i data-lucide="image" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Gallery</span>
                    </a>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.testimonial.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/testimonial*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Testimonial">
                        <i data-lucide="message-square" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Testimonial</span>
                    </a>
                </div>
            </div>

            <!-- System -->
            <div>
                <p class="sidebar-label text-[10px] font-extrabold text-[#94a3b8] dark:text-[#475569] uppercase tracking-widest mb-4 px-2">SYSTEM</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.vacancy.index') }}"
                        class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                        {{ request()->is('admin/vacancy*') ? 'bg-[#0062ff] text-white shadow-lg shadow-blue-500/20' : 'text-[#64748b] dark:text-[#94a3b8] hover:bg-slate-50 dark:hover:bg-slate-800' }}" title="Vacancies">
                        <i data-lucide="briefcase" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Vacancies</span>
                    </a>
                    <a href="#" class="sidebar-link relative flex items-center gap-3 px-3 py-2.5 text-[#64748b] dark:text-[#94a3b8] rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200" title="Site Settings">
                        <i data-lucide="settings" class="w-[18px] h-[18px] flex-shrink-0"></i>
                        <span class="sidebar-text text-[13px] font-bold">Site Settings</span>
                    </a>

                </div>
            </div>
        </nav>

        <!-- Bottom Sign Out -->
        <div class="mt-auto pt-6">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link flex items-center gap-3 px-2 py-2 text-[#ff3b3b] font-black uppercase tracking-[0.15em] text-[11px]" title="Sign Out">
                    <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0 transition-transform hover:-translate-x-1"></i>
                    <span class="sidebar-text">SIGN OUT</span>
                </button>
            </form>
        </div>
    </div>
</aside>