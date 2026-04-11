@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">@yield('page_title', 'Dashboard')</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">@yield('page_description', 'Institutional Dashboard')</p>
    </div>
    <div class="flex items-center gap-4 mt-6 md:mt-0">
        <button class="flex items-center gap-2 px-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-[11px] font-black text-slate-900 dark:text-white uppercase tracking-[0.2em] shadow-sm hover:bg-slate-50 transition-all">
            <i data-lucide="globe" class="w-4 h-4"></i>
            Live Website
        </button>
        <button class="flex items-center gap-2 px-6 py-3.5 bg-[#001c3d] dark:bg-blue-700 rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 transition-all group">
            <i data-lucide="zap" class="w-4 h-4 fill-white group-hover:scale-125 transition-transform"></i>
            Urgent Alert
        </button>
    </div>
</div>
<!-- Metric Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Departments -->
    <div class="bg-white p-8 rounded-[2rem] border border-[#f1f5f9] relative group">
        <div class="flex items-center justify-between mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#eff6ff] text-[#0062ff] flex items-center justify-center">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
            <span class="text-[9px] font-black bg-[#eff6ff] text-[#0062ff] px-2.5 py-1.5 rounded-full">+1 NEW</span>
        </div>
        <p class="text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.15em] mb-1">DEPARTMENTS</p>
        <h3 class="text-[42px] font-black text-[#111827] leading-none">11</h3>
    </div>

    <!-- Faculty -->
    <div class="bg-white p-8 rounded-[2rem] border border-[#f1f5f9] relative group">
        <div class="flex items-center justify-between mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#f0fdf4] text-[#22c55e] flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <span class="text-[9px] font-black bg-[#f0fdf4] text-[#22c55e] px-2.5 py-1.5 rounded-full">+4 NEW</span>
        </div>
        <p class="text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.15em] mb-1">FACULTY MEMBERS</p>
        <h3 class="text-[42px] font-black text-[#111827] leading-none">145</h3>
    </div>

    <!-- Placement -->
    <div class="bg-white p-8 rounded-[2rem] border border-[#f1f5f9] relative group">
        <div class="flex items-center justify-between mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#f5f3ff] text-[#6366f1] flex items-center justify-center">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
            <span class="text-[9px] font-black bg-[#f5f3ff] text-[#6366f1] px-2.5 py-1.5 rounded-full">+12% YOY</span>
        </div>
        <p class="text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.15em] mb-1">PLACEMENT RECORD</p>
        <h3 class="text-[42px] font-black text-[#111827] leading-none">82%</h3>
    </div>

    <!-- Notices -->
    <div class="bg-white p-8 rounded-[2rem] border border-[#f1f5f9] relative group">
        <div class="flex items-center justify-between mb-8">
            <div class="w-12 h-12 rounded-2xl bg-[#fff7ed] text-[#f97316] flex items-center justify-center">
                <i data-lucide="bell" class="w-6 h-6"></i>
            </div>
            <span class="text-[9px] font-black bg-[#fff7ed] text-[#f97316] px-2.5 py-1.5 rounded-full uppercase">UPDATED 2H AGO</span>
        </div>
        <p class="text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.15em] mb-1">ACTIVE NOTICES</p>
        <h3 class="text-[42px] font-black text-[#111827] leading-none">24</h3>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Institutional Controls -->
    <div class="flex-grow bg-white p-10 lg:p-12 rounded-[2.5rem] shadow-sm">
        <div class="flex items-center gap-4 mb-12">
            <div class="w-10 h-10 rounded-2xl bg-[#eff6ff] text-[#0062ff] flex items-center justify-center">
                <i data-lucide="zap" class="w-5 h-5 fill-[#0062ff]"></i>
            </div>
            <h2 class="text-2xl font-black text-[#111827] tracking-tight">Institutional Controls</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $controls = [
            ['title' => 'HOME BASE', 'icon' => 'layout-grid', 'color' => '#3b82f6'],
            ['title' => 'CAMPUS PROFILE', 'icon' => 'file-text', 'color' => '#22c55e'],
            ['title' => 'DEPARTMENT HUD', 'icon' => 'building', 'color' => '#f97316'],
            ['title' => 'ACADEMIC DOCS', 'icon' => 'graduation-cap', 'color' => '#8b5cf6'],
            ['title' => 'STUDENT PORTAL', 'icon' => 'users', 'color' => '#ec4899'],
            ['title' => 'LIVE NOTICES', 'icon' => 'video', 'color' => '#ef4444'],
            ];
            @endphp

            @foreach($controls as $control)
            <div class="bg-[#f8fafc] p-10 rounded-3xl border border-transparent hover:border-[#e2e8f0] hover:bg-white transition-all group flex flex-col items-center justify-center text-center cursor-pointer">
                <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center mb-6 shadow-sm group-hover:shadow-md transition-all">
                    <i data-lucide="{{ $control['icon'] }}" class="w-7 h-7" style="color: {{ $control['color'] }}"></i>
                </div>
                <h4 class="text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em] group-hover:text-slate-900 transition-colors">{{ $control['title'] }}</h4>
            </div>
            @endforeach
        </div>
    </div>

    <!-- System Pulse -->
    <div class="w-full lg:w-[420px] bg-[#001c3d] p-12 rounded-[2.5rem] text-white flex flex-col items-start relative overflow-hidden group">
        <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center mb-10 border border-white/5">
            <i data-lucide="activity" class="w-7 h-7 text-[#0062ff]"></i>
        </div>
        <h2 class="text-[34px] font-black mb-4 tracking-tighter leading-none">System Pulse</h2>
        <p class="text-slate-400 text-sm font-semibold mb-12">Institutional networks and management protocols are fully operational.</p>

        <div class="w-full space-y-4">
            <div class="bg-white/5 p-5 rounded-2xl border border-white/5 flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-widest text-[#94a3b8]">NEURAL ENGINE</span>
                <span class="text-[9px] font-black bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> RUNNING
                </span>
            </div>
            <div class="bg-white/5 p-5 rounded-2xl border border-white/5 flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-widest text-[#94a3b8]">MAIN REGISTRY</span>
                <span class="text-[9px] font-black bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> SECURED
                </span>
            </div>
            <div class="bg-white/5 p-5 rounded-2xl border border-white/5 flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-widest text-[#94a3b8]">PUBLIC GATEWAY</span>
                <span class="text-[9px] font-black bg-blue-500/10 text-[#0062ff] px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#0062ff]"></span> ACTIVE
                </span>
            </div>
        </div>
        <!-- Decorative bg circle -->
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-[#0062ff]/5 rounded-full blur-3xl transition-all group-hover:bg-[#0062ff]/10"></div>
    </div>
</div>
@endsection