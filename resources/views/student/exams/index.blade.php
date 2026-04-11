@extends('layouts.student')

@section('title', 'Exam Portal')

@section('content')
<div class="max-w-5xl">
    <div class="mb-10">
        <h3 class="text-2xl font-bold text-slate-800 font-Outfit">Automarks Examination Center</h3>
        <p class="text-slate-500">View and attempt your course certifications here.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Eligible Exam -->
        <div class="card p-8 bg-white border-blue-100 flex flex-col justify-between shadow-sm hover:shadow-xl transition-all h-[400px]">
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-3xl flex items-center justify-center text-blue-600">
                        <i data-lucide="award" class="w-8 h-8"></i>
                    </div>
                    <span class="px-4 py-1.5 bg-emerald-100 text-emerald-600 rounded-lg text-xs font-bold tracking-tight uppercase">Eligible</span>
                </div>
                
                <h4 class="text-2xl font-bold text-slate-800 mb-2">Tally Prime Basics</h4>
                <p class="text-sm text-slate-500 mb-6 font-medium">Certification exam for Level 1 Fundamentals.</p>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-center text-sm font-medium text-slate-600">
                        <i data-lucide="list-checks" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>50 Multiple Choice Questions</span>
                    </div>
                    <div class="flex items-center text-sm font-medium text-slate-600">
                        <i data-lucide="timer" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>60 Minutes Duration</span>
                    </div>
                    <div class="flex items-center text-sm font-medium text-slate-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 mr-3 text-slate-400"></i>
                        <span>Passing Score: 40%</span>
                    </div>
                </div>
            </div>

            <a href="#" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold text-center hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Start Examination</a>
        </div>

        <!-- Locked Exam -->
        <div class="card p-8 bg-slate-50 border-slate-100 opacity-70 flex flex-col justify-between h-[400px]">
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="w-16 h-16 bg-slate-200 rounded-3xl flex items-center justify-center text-slate-500">
                        <i data-lucide="lock" class="w-8 h-8"></i>
                    </div>
                    <span class="px-4 py-1.5 bg-slate-200 text-slate-500 rounded-lg text-xs font-bold tracking-tight uppercase">Locked</span>
                </div>
                
                <h4 class="text-2xl font-bold text-slate-800 mb-2">Advanced Share Market</h4>
                <p class="text-sm text-slate-500 mb-6 font-medium">Complete all course chapters to unlock this exam.</p>
                
                <div class="bg-white rounded-2xl p-4 border border-slate-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase">Progress</span>
                        <span class="text-xs font-bold text-blue-600">45%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full w-[45%]"></div>
                    </div>
                </div>
            </div>

            <button disabled class="w-full py-4 bg-slate-200 text-slate-400 rounded-2xl font-bold cursor-not-allowed">Wait for completion</button>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mt-16 p-8 bg-blue-900 rounded-[2.5rem] text-white overflow-hidden relative">
        <div class="relative z-10">
            <h5 class="text-xl font-bold mb-6">Examination Instructions</h5>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm text-blue-100 leading-relaxed">
                <div>
                    <h6 class="text-white font-bold mb-2">1. One Attempt Only</h6>
                    <p>Once you start the examination, your single allowed attempt is consumed. Ensure a stable internet connection.</p>
                </div>
                <div>
                    <h6 class="text-white font-bold mb-2">2. Timed window</h6>
                    <p>The timer cannot be paused. If you close the window, the exam will auto-submit with current answers.</p>
                </div>
                <div>
                    <h6 class="text-white font-bold mb-2">3. Instant Certificate</h6>
                    <p>Passing students can download their auto-generated photo certificate immediately after submission.</p>
                </div>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-800 rounded-full opacity-50"></div>
    </div>
</div>
@endsection
