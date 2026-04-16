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
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded">My Education</span>
        </div>
        <h3 class="text-2xl font-bold">{{ str_pad($activeCoursesCount, 2, '0', STR_PAD_LEFT) }}</h3>
        <p class="text-blue-100 text-sm">Active Courses</p>
    </div>

    <div class="card flex items-center space-x-5">
        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
            <i data-lucide="award" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ str_pad($certificatesCount, 2, '0', STR_PAD_LEFT) }}</h3>
            <p class="text-sm text-slate-500 font-medium">Certificates</p>
        </div>
    </div>

    <div class="card flex items-center space-x-5">
        <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
            <i data-lucide="credit-card" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">INR {{ number_format($pendingFees) }}</h3>
            <p class="text-sm text-slate-500 font-medium">Pending Fees</p>
        </div>
    </div>

    <div class="card flex items-center space-x-5">
        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
            <i data-lucide="check-circle" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $attendancePercentage }}%</h3>
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
                @forelse($enrolledCourses as $course)
                    <div class="min-w-[300px] group cursor-pointer" onclick="window.location='{{ route('student.learning', $course->id) }}'">
                        <div class="relative rounded-3xl overflow-hidden aspect-video mb-4 shadow-sm group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-300">
                            <img src="{{ $course->image }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                                <span class="text-white text-xs font-bold px-2 py-1 bg-blue-600 rounded">Course</span>
                            </div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-xl">
                                    <i data-lucide="play" class="w-6 h-6 fill-current"></i>
                                </div>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-2 truncate">{{ $course->name }}</h4>
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-blue-600">Modules</span>
                            <span class="text-slate-400">{{ $course->subjects->sum(fn($s) => $s->units->count()) }} Units Total</span>
                        </div>
                        <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2">
                            <div class="bg-blue-600 h-1.5 rounded-full w-[25%] transition-all duration-1000"></div>
                        </div>
                    </div>
                @empty
                    <div class="w-full p-10 bg-white rounded-3xl border-2 border-dashed border-slate-100 text-center">
                        <p class="text-slate-400 font-medium">You haven't enrolled in any courses yet.</p>
                        <a href="{{ route('courses') }}" class="text-blue-600 font-bold mt-2 inline-block">Browse Courses &rarr;</a>
                    </div>
                @endforelse
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
                        <h4 class="text-lg font-bold text-slate-800 mb-2">{{ $latestCourse ? $latestCourse->name : 'No Active Course' }}</h4>
                        <p class="text-sm text-slate-500 mb-6">
                            {{ $latestCourse ? 'A new exam is ready for your latest enrolled course.' : 'Enroll in a course to unlock quizzes and exams.' }}
                        </p>
                    </div>
                    <a href="{{ $latestCourse ? route('student.exams') : route('courses') }}" class="btn-primary text-center">{{ $latestCourse ? 'Start Exam Now' : 'Browse Courses' }}</a>
                </div>

                <!-- Locked Exam -->
                <div class="card {{ $activeCoursesCount ? 'opacity-60 grayscale cursor-not-allowed' : '' }} flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-2 {{ $activeCoursesCount ? 'text-slate-400' : 'text-blue-600' }} mb-4 font-bold text-sm">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>{{ $activeCoursesCount ? 'Chapter Locked' : 'Get Started' }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">{{ $activeCoursesCount ? 'Advanced Accounting' : 'First Course Enrollment' }}</h4>
                        <p class="text-sm text-slate-500 mb-6 font-medium italic">
                            {{ $activeCoursesCount ? 'Complete 100% of chapters to unlock this chapter.' : 'Choose your first course and begin learning today.' }}
                        </p>
                    </div>
                    <button {{ $activeCoursesCount ? 'disabled' : '' }} class="w-full py-3 {{ $activeCoursesCount ? 'bg-slate-200 text-slate-500 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700' }} rounded-xl font-bold">{{ $activeCoursesCount ? 'Access Blocked' : 'Enroll Now' }}</button>
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
                @forelse($announcements as $announcement)
                    <div class="p-5 bg-white rounded-[2rem] border border-slate-100 relative shadow-sm hover:shadow-md transition">
                        <span class="absolute top-4 right-4 text-[10px] font-bold uppercase tracking-tighter {{ $announcement['type'] === 'exam' ? 'text-blue-600' : 'text-emerald-600' }}">
                            {{ $announcement['label'] }}
                        </span>
                        <h5 class="font-bold text-slate-800 pr-10 mb-2">{{ $announcement['title'] }}</h5>
                        <p class="text-sm text-slate-500 mb-3">{{ $announcement['description'] }}</p>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 mb-3">
                            <span>{{ $announcement['date'] }}</span>
                            <span>{{ ucfirst($announcement['type']) }} Notification</span>
                        </div>
                        <a href="{{ $announcement['link'] }}" class="text-xs font-bold text-blue-600">{{ $announcement['linkLabel'] }} &rarr;</a>
                    </div>
                @empty
                    <div class="p-5 bg-white rounded-[2rem] border border-slate-100 shadow-sm text-slate-500">
                        No new announcements at this time.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Payments -->
        <div>
            <h3 class="text-xl font-bold text-slate-800 mb-6">Recent Payments</h3>
            <div class="card !p-0 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-800">Transaction History</h4>
                        <p class="text-xs text-slate-500">Your latest fee payments are listed below.</p>
                    </div>
                    <a href="{{ route('student.financials') }}" class="text-xs font-bold text-blue-600 px-4 py-2 bg-blue-50 rounded-lg hover:bg-blue-100 transition">View All Transactions</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 bg-white">
                                <th class="px-8 py-4">Ref No.</th>
                                <th class="px-8 py-4">Description</th>
                                <th class="px-8 py-4">Method</th>
                                <th class="px-8 py-4">Date</th>
                                <th class="px-8 py-4">Amount</th>
                                <th class="px-8 py-4 text-center">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentPayments as $payment)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-6 font-mono text-xs text-slate-500">{{ $payment['reference'] }}</td>
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-bold text-slate-800">{{ $payment['description'] }}</p>
                                        <p class="text-[10px] text-slate-500 font-medium">{{ $payment['course'] }}</p>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $payment['method'] === 'ONLINE' ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-600' }}">{{ $payment['method'] }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-sm text-slate-600">{{ $payment['date'] }}</td>
                                    <td class="px-8 py-6 font-bold text-slate-900">INR {{ number_format($payment['amount']) }}</td>
                                    <td class="px-8 py-6 text-center">
                                        <a href="{{ route('student.receipt.download', $payment['reference']) }}" class="inline-flex items-center justify-center w-10 h-10 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">
                                            <i data-lucide="download" class="w-5 h-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
