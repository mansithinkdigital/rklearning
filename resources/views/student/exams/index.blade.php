@extends('layouts.student')

@section('title', 'Exam Portal')

@section('content')
<div class="max-w-7xl">
    <div class="mb-12">
        <h3 class="text-[34px] font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">Examination Center</h3>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Subject-wise assessments and certifications</p>
    </div>

    @if($courseSubjects->isEmpty())
    <div class="p-20 bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 text-center shadow-sm">
        <div class="w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600">
            <i data-lucide="book" class="w-10 h-10"></i>
        </div>
        <h4 class="text-2xl font-black text-slate-800 dark:text-white mb-2 uppercase tracking-tight">No Subscribed Subjects</h4>
        <p class="text-slate-500 font-medium max-w-sm mx-auto mb-8">Enroll in a course to unlock project-based assessments and earn certifications.</p>
        <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-blue-200">Browse Projects</a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courseSubjects as $cs)
        <div class="group h-full flex flex-col bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-200 dark:shadow-none transition-transform group-hover:rotate-6">
                    <i data-lucide="{{ $cs->mcqs->count() > 0 ? 'award' : 'lock' }}" class="w-6 h-6"></i>
                </div>
                @if($cs->mcqs->count() > 0)
                    <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-lg text-[10px] font-black uppercase tracking-widest">Active Exam</span>
                @else
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest">Questions Pending</span>
                @endif
            </div>
            
            <div class="mb-8">
                <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-[0.2em] mb-2">{{ $cs->course->name }}</p>
                <h4 class="text-xl font-black text-slate-900 dark:text-white tracking-tight uppercase leading-tight">{{ $cs->subject->name }}</h4>
            </div>

            <div class="space-y-4 mb-10 mt-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="list-checks" class="w-4 h-4 text-slate-400"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $cs->mcqs->count() }} Questions</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                            {{ $cs->mcqs->count() * 1.5 }} Minutes
                        </span>
                    </div>
                </div>
            </div>

            @if($cs->mcqs->count() > 0)
                <a href="#" class="w-full py-4 bg-slate-900 dark:bg-blue-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest text-center group-hover:bg-blue-600 transition-colors shadow-xl shadow-blue-100 dark:shadow-none">
                    Start Examination
                </a>
            @else
                <button disabled class="w-full py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest text-center cursor-not-allowed">
                    Locked
                </button>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Instructions -->
    <div class="mt-20 p-12 bg-gradient-to-br from-slate-900 to-black rounded-[3rem] text-white relative overflow-hidden group shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1">
                <h5 class="text-2xl font-black mb-6 uppercase tracking-tight">Proctoring Instructions</h5>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center shrink-0"><i data-lucide="zap" class="w-5 h-5 text-blue-400"></i></div>
                        <div>
                            <h6 class="font-black text-xs uppercase tracking-widest mb-1 text-white">Stability</h6>
                            <p class="text-sm text-slate-400 font-medium leading-relaxed">Ensure power backup and 4G/Wifi stability before launching.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center shrink-0"><i data-lucide="user-x" class="w-5 h-5 text-blue-400"></i></div>
                        <div>
                            <h6 class="font-black text-xs uppercase tracking-widest mb-1 text-white">Single session</h6>
                            <p class="text-sm text-slate-400 font-medium leading-relaxed">The portal locks once started. Do not refresh or exit browser.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-fit">
                <div class="p-8 bg-blue-600 rounded-[2.5rem] text-center shadow-2xl shadow-blue-500/20 group-hover:scale-105 transition-all duration-500 whitespace-nowrap">
                    <i data-lucide="shield-check" class="w-12 h-12 mb-4 mx-auto text-white"></i>
                    <p class="text-[10px] font-black uppercase tracking-widest">Trusted By</p>
                    <p class="text-lg font-black tracking-tight">ISO 9001:2015 Hub</p>
                </div>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-600/10 rounded-full blur-[100px] group-hover:scale-150 transition-transform duration-1000"></div>
    </div>
</div>
@endsection
