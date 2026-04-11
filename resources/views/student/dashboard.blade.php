@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome & Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="card bg-gradient-to-br from-blue-600 to-blue-700 text-white border-none">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded">Semester 1</span>
        </div>
        <h3 class="text-2xl font-bold">03</h3>
        <p class="text-blue-100 text-sm">Active Courses</p>
    </div>

    <div class="card flex items-center space-x-5">
        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
            <i data-lucide="award" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">01</h3>
            <p class="text-sm text-slate-500 font-medium">Certificates</p>
        </div>
    </div>

    <div class="card flex items-center space-x-5">
        <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
            <i data-lucide="credit-card" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">INR 0</h3>
            <p class="text-sm text-slate-500 font-medium">Pending Fees</p>
        </div>
    </div>

    <div class="card flex items-center space-x-5">
        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
            <i data-lucide="check-circle" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">85%</h3>
            <p class="text-sm text-slate-500 font-medium">Attendance</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-10">
        <!-- Netflix Style Course Grid -->
        <section>
            <div class="flex items-center justify-between mb-6 px-2">
                <h3 class="text-xl font-bold text-slate-800">Continue Learning</h3>
                <div class="flex space-x-2">
                    <button class="p-2 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-blue-600 transition"><i data-lucide="chevron-left" class="w-5 h-5"></i></button>
                    <button class="p-2 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-blue-600 transition"><i data-lucide="chevron-right" class="w-5 h-5"></i></button>
                </div>
            </div>

            <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide px-2">
                <!-- Course Item 1 -->
                <div class="min-w-[300px] group cursor-pointer">
                    <div class="relative rounded-3xl overflow-hidden aspect-video mb-4 shadow-sm group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?q=80&w=2062&auto=format&fit=crop" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                            <span class="text-white text-xs font-bold px-2 py-1 bg-blue-600 rounded">PHP / Laravel</span>
                        </div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-xl">
                                <i data-lucide="play" class="w-6 h-6 fill-current"></i>
                            </div>
                        </div>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-2 truncate">Full Stack Web Development with Laravel</h4>
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-blue-600">65% Completed</span>
                        <span class="text-slate-400">12/18 Lessons</span>
                    </div>
                    <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2">
                        <div class="bg-blue-600 h-1.5 rounded-full w-[65%]"></div>
                    </div>
                </div>

                <!-- Course Item 2 -->
                <div class="min-w-[300px] group cursor-pointer">
                    <div class="relative rounded-3xl overflow-hidden aspect-video mb-4 shadow-sm group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=2022&auto=format&fit=crop" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                            <span class="text-white text-xs font-bold px-2 py-1 bg-orange-600 rounded">Tally Prime</span>
                        </div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-orange-600 shadow-xl">
                                <i data-lucide="play" class="w-6 h-6 fill-current"></i>
                            </div>
                        </div>
                    </div>
                    <h4 class="font-bold text-slate-800 mb-2 truncate">Professional Tally Prime Accounting</h4>
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-orange-600">20% Completed</span>
                        <span class="text-slate-400">4/20 Lessons</span>
                    </div>
                    <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2">
                        <div class="bg-orange-600 h-1.5 rounded-full w-[20%]"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Exam Portal Summary -->
        <section>
            <h3 class="text-xl font-bold text-slate-800 mb-6 px-2">Exam Portal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Active Exam -->
                <div class="card border-blue-100 bg-blue-50/30 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-2 text-blue-600 mb-4 font-bold text-sm">
                            <i data-lucide="unlock" class="w-4 h-4"></i>
                            <span>Active Exam</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Tally Basics Level 1</h4>
                        <p class="text-sm text-slate-500 mb-6">Eligible for certification after passing this test.</p>
                    </div>
                    <a href="#" class="btn-primary text-center">Start Exam Now</a>
                </div>

                <!-- Locked Exam -->
                <div class="card opacity-60 grayscale cursor-not-allowed flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-2 text-slate-400 mb-4 font-bold text-sm">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>Chapter Locked</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">Advanced Accounting</h4>
                        <p class="text-sm text-slate-500 mb-6 font-medium italic">Complete 100% of chapters to unlock.</p>
                    </div>
                    <button disabled class="w-full py-3 bg-slate-200 text-slate-500 rounded-xl font-bold cursor-not-allowed">Access Blocked</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Announcements -->
        <div>
            <h3 class="text-xl font-bold text-slate-800 mb-6">Announcements</h3>
            <div class="space-y-4">
                <div class="p-5 bg-white rounded-[2rem] border border-slate-100 relative shadow-sm hover:shadow-md transition">
                    <span class="absolute top-4 right-4 text-[10px] font-bold text-blue-600 uppercase tracking-tighter">Event</span>
                    <h5 class="font-bold text-slate-800 pr-10 mb-2">Guest Lecture on AI</h5>
                    <p class="text-sm text-slate-500 mb-3">Join us this Sunday at 11 AM via Zoom link in the events tab.</p>
                    <a href="#" class="text-xs font-bold text-blue-600">Join Link &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div>
            <h3 class="text-xl font-bold text-slate-800 mb-6">Recent Payments</h3>
            <div class="card !p-0 overflow-hidden">
                <div class="p-5 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600"><i data-lucide="download" class="w-5 h-5"></i></div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Term 1 Fees</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">12 April, 2026</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-blue-600">INR 5,500</span>
                </div>
                <div class="p-4 bg-slate-50 text-center">
                    <a href="#" class="text-xs font-bold text-slate-500 hover:text-blue-600">View All Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
