@extends('layouts.student')

@section('title', 'My Certificates & Achievements')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Section -->
    <div class="mb-12">
        <h3 class="text-[34px] font-black text-slate-900 tracking-tight leading-none mb-3">Academic Achievements</h3>
        <p class="text-[14px] font-bold text-slate-400 uppercase tracking-widest">Your verified certifications and performance records</p>
    </div>

    @if($completedCourses->isEmpty())
    <div class="p-20 bg-white rounded-[3rem] border border-slate-100 text-center shadow-sm">
        <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600 shadow-inner">
            <i data-lucide="award" class="w-10 h-10"></i>
        </div>
        <h4 class="text-2xl font-black text-slate-800 mb-2 uppercase tracking-tight">No Certificates Yet</h4>
        <p class="text-slate-500 font-medium max-w-sm mx-auto mb-8">Complete all video lessons and pass your examinations to unlock your official certifications.</p>
        <a href="{{ route('student.my-courses') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-blue-200">Go to My Courses</a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($completedCourses as $c)
        <div class="group bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <!-- Course Banner -->
            <div class="h-32 bg-gradient-to-r from-emerald-500 to-teal-600 relative overflow-hidden p-8 flex items-center">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-0.5 bg-white/20 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-white border border-white/20">Verified Achievement</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                    </div>
                    <h4 class="text-xl sm:text-2xl font-black text-white uppercase tracking-tight truncate max-w-md">{{ $c->name }}</h4>
                </div>
                <!-- Decorative Icon -->
                <i data-lucide="shield-check" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12 transition-transform group-hover:scale-110"></i>
            </div>

            <!-- Content Area -->
            <div class="p-8">
                <!-- Stats Row -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="play-circle" class="w-3.5 h-3.5 text-blue-600"></i>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Video Completion</span>
                        </div>
                        <p class="text-lg font-black text-slate-900">{{ $c->progress_percent }}%</p>
                        <div class="w-full bg-slate-200 h-1 rounded-full mt-2 overflow-hidden">
                            <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: {{ $c->progress_percent }}%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Exam Date</span>
                        </div>
                        <p class="text-lg font-black text-slate-900">{{ $c->exam_date }}</p>
                    </div>
                </div>

                <!-- Course Description Snippet -->
                <div class="mb-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Credential Description</p>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed italic">
                        "Successfully completed the comprehensive program in {{ $c->name }}, demonstrating proficiency through project-based assessments and video-guided practical training."
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <!-- Certificate Section -->
                    <div class="p-4 border border-slate-100 rounded-3xl bg-slate-50/50">
                        <div class="flex items-center justify-between mb-4 px-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="award" class="w-4 h-4"></i>
                                </div>
                                <span class="text-xs font-black text-slate-900 uppercase tracking-tight">Completion Certificate</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('student.certificate.preview', $c->id) }}" target="_blank" class="flex items-center justify-center gap-2 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Preview
                            </a>
                            <a href="{{ route('student.certificate.download', $c->id) }}" class="flex items-center justify-center gap-2 py-3 bg-blue-600 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i> Download
                            </a>
                        </div>
                    </div>
                    <!-- Marksheet Section -->
                    <div class="p-4 border border-slate-100 rounded-3xl bg-slate-50/50">
                        <div class="flex items-center justify-between mb-4 px-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <span class="text-xs font-black text-slate-900 uppercase tracking-tight">Academic Marksheet</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('student.marksheet.preview', $c->id) }}" target="_blank" class="flex items-center justify-center gap-2 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Preview
                            </a>
                            <a href="{{ route('student.marksheet.download', $c->id) }}" class="flex items-center justify-center gap-2 py-3 bg-emerald-600 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection
