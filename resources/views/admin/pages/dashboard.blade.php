@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-10">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-[#001c3d] p-8 md:p-12 text-white shadow-2xl shadow-blue-900/20">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-4 text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    System Live
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-none text-white">
                    Welcome back,<br/>
                    <span class="text-blue-400">Admin Commander</span>
                </h1>
                <p class="text-slate-400 max-w-md text-sm md:text-base font-medium">
                    Your institutional dashboard is fully synchronized. All faculty, students, and course modules are active and under monitoring.
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/" target="_blank" class="flex items-center gap-2 px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-xs font-black uppercase tracking-widest transition-all group">
                    <i data-lucide="external-link" class="w-4 h-4 text-blue-400"></i>
                    View Website
                </a>
                <button class="flex items-center gap-2 px-6 py-4 bg-blue-600 hover:bg-blue-500 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-600/30 transition-all group">
                    <i data-lucide="plus" class="w-4 h-4 text-white group-hover:rotate-90 transition-transform"></i>
                    Quick Action
                </button>
            </div>
        </div>
        
        <!-- Animated Background Elements -->
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[150%] h-[150%] border-[1px] border-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] border-[1px] border-white/5 rounded-full pointer-events-none"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6">
        <!-- Departments -->
        <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500">
            <div class="flex h-full flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="building-2" class="w-7 h-7 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-black italic tracking-widest">+12%</span>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none mb-2">{{ $departmentsCount }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Departments</p>
                </div>
            </div>
        </div>

        <!-- Faculty -->
        <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-emerald-500/30 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500">
            <div class="flex h-full flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="users" class="w-7 h-7 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-black italic tracking-widest">STABLE</span>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none mb-2">{{ $facultyCount }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Faculty Members</p>
                </div>
            </div>
        </div>

        <!-- Courses -->
        <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-indigo-500/30 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="flex h-full flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="book-open" class="w-7 h-7 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black italic tracking-widest">+5 NEW</span>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none mb-2">{{ $activeCoursesCount }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Courses</p>
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500">
            <div class="flex h-full flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="graduation-cap" class="w-7 h-7 text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 text-[10px] font-black italic tracking-widest">+2.4k</span>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none mb-2">{{ $studentsCount }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Enrolled Students</p>
                </div>
            </div>
        </div>

        <!-- Reattempt Requests -->
        <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-purple-500/30 hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 {{ $reattemptRequestsCount > 0 ? 'ring-2 ring-purple-500/20 ring-offset-2' : '' }}">
            <div class="flex h-full flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-950/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="rotate-cw" class="w-7 h-7 text-purple-600 dark:text-purple-400 {{ $reattemptRequestsCount > 0 ? 'animate-spin-slow' : '' }}"></i>
                    </div>
                    @if($reattemptRequestsCount > 0)
                        <span class="px-3 py-1 rounded-full bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 text-[10px] font-black italic tracking-widest">PENDING</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-black italic tracking-widest">CLEAR</span>
                    @endif
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none mb-2">{{ $reattemptRequestsCount }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Reattempt Requests</p>
                </div>
            </div>
            @if($reattemptRequestsCount > 0)
            <a href="{{ route('admin.exam-results.index') }}" class="absolute inset-0 z-10" aria-label="View Reattempt Requests"></a>
            @endif
        </div>
    </div>

    <!-- Main Grid Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        <!-- Control Center -->
        <div class="xl:col-span-2 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Institutional Controls</h2>
                    <p class="text-sm font-bold text-slate-400">Direct access to core modules</p>
                </div>
                <button class="text-xs font-black text-blue-600 uppercase tracking-widest hover:underline transition-all">Customize Menu</button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                @php
                $controls = [
                    ['title' => 'Student HUD', 'icon' => 'users', 'color' => '#3b82f6', 'route' => 'admin.student.index'],
                    ['title' => 'Course Matrix', 'icon' => 'layers', 'color' => '#10b981', 'route' => 'admin.course.index'],
                    ['title' => 'Branch CMS', 'icon' => 'map-pin', 'color' => '#f59e0b', 'route' => 'admin.branch.index'],
                    ['title' => 'Free Assets', 'icon' => 'file-text', 'color' => '#6366f1', 'route' => 'admin.free-pdf.index'],
                    ['title' => 'Video Library', 'icon' => 'video', 'color' => '#ef4444', 'route' => 'admin.free-video.index'],
                    ['title' => 'Gallery Hub', 'icon' => 'image', 'color' => '#ec4899', 'route' => 'admin.gallery.index'],
                ];
                @endphp

                @foreach($controls as $control)
                <a href="{{ Route::has($control['route']) ? route($control['route']) : '#' }}" class="group bg-white dark:bg-slate-900 p-6 md:p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-blue-500/20 hover:shadow-xl transition-all flex flex-col items-center text-center">
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-all shadow-sm">
                        <i data-lucide="{{ $control['icon'] }}" class="w-7 h-7 md:w-8 md:h-8" style="color: {{ $control['color'] }}"></i>
                    </div>
                    <h4 class="text-[12px] font-black text-slate-900 dark:text-white uppercase tracking-widest leading-tight">{{ $control['title'] }}</h4>
                </a>
                @endforeach
            </div>
        </div>

        <!-- System Intelligence -->
        <div class="space-y-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Intelligence</h2>
                <p class="text-sm font-bold text-slate-400">Live system status & logs</p>
            </div>

            <div class="bg-[#001c3d] p-10 rounded-[2.5rem] text-white flex flex-col items-start relative overflow-hidden group min-h-[500px]">
                <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center mb-10 border border-white/5">
                    <i data-lucide="cpu" class="w-7 h-7 text-blue-400"></i>
                </div>
                
                <div class="relative z-10 w-full flex-grow space-y-12">
                    <div class="space-y-4">
                        <h2 class="text-3xl font-black tracking-tighter leading-none">Kernel Status</h2>
                        <p class="text-slate-400 text-sm font-medium">All decentralized nodes are currently broadcasting at optimal frequency.</p>
                    </div>

                    <div class="w-full space-y-4">
                        <div class="bg-white/5 p-5 rounded-2xl border border-white/5 flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Main Gateway</span>
                            <span class="flex items-center gap-2 text-[9px] font-black bg-emerald-500/10 text-emerald-400 px-3 py-1.5 rounded-full uppercase tracking-widest">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_10px_#34d399]"></span> SECURED
                            </span>
                        </div>
                        <div class="bg-white/5 p-5 rounded-2xl border border-white/5 flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Database Engine</span>
                            <span class="flex items-center gap-2 text-[9px] font-black bg-blue-500/10 text-blue-400 px-3 py-1.5 rounded-full uppercase tracking-widest">
                                <span class="w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_10px_#60a5fa]"></span> SYNCED
                            </span>
                        </div>
                        <div class="bg-white/5 p-5 rounded-2xl border border-white/5 flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Neural Assets</span>
                            <span class="flex items-center gap-2 text-[9px] font-black bg-emerald-500/10 text-emerald-400 px-3 py-1.5 rounded-full uppercase tracking-widest">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_10px_#34d399]"></span> OPTIMAL
                            </span>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-white/10 mt-auto">
                        <button class="w-full py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-black uppercase tracking-widest transition-all">
                            Review System Logs
                        </button>
                    </div>
                </div>

                <!-- Decorative Background -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-600/5 rounded-full blur-3xl pointer-events-none transition-all group-hover:bg-blue-600/10"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,#0062ff05,transparent)]"></div>
            </div>
        </div>
    </div>
</div>
@endsection