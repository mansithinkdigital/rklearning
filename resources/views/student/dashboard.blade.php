@extends('layouts.student')
@section('title', 'Student Dashboard')
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
@if($completedCourses->isNotEmpty())
<section class="mb-10">
    <div class="flex items-center justify-between mb-6 px-2">
        <h3 class="text-xl font-bold text-slate-800">Your Certificates</h3>
        <p class="text-sm text-slate-500 font-medium">Official Credentials Earned</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($completedCourses as $course)
        <div class="card bg-gradient-to-br from-emerald-600 to-emerald-800 text-white border-none p-6 rounded-[2rem] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xl">
            <div>
                <span class="px-3 py-1 bg-emerald-500/30 rounded-full text-[9px] font-black uppercase tracking-[0.2em] text-emerald-100 border border-emerald-400/20">Official Credential</span>
                <h4 class="text-lg font-bold mt-3 text-white">{{ $course->name }}</h4>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('student.certificate.preview', $course->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-700/50 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-700 transition-all border border-emerald-500/30">
                    <i data-lucide="eye" class="w-4 h-4"></i> Certificate
                </a>
                <a href="{{ route('student.marksheet.preview', $course->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-700/50 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-700 transition-all border border-emerald-500/30">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Marksheet
                </a>
                <a href="{{ route('student.certificate.download', $course->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-emerald-800 rounded-xl font-bold text-xs uppercase tracking-wider hover:scale-105 transition-all shadow-md">
                    <i data-lucide="award" class="w-4 h-4"></i> Download
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<section class="mb-10">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-slate-800">Free Learning Resources</h3>
        <p class="text-sm text-slate-500 font-medium">Accessible to all registered students</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('student.free-videos') }}" class="group block h-full">
            <div class="card bg-white border-slate-100 flex items-center gap-5 hover:border-blue-600 transition-all cursor-pointer overflow-hidden relative h-full">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shrink-0 relative">
                    <i data-lucide="video" class="w-7 h-7"></i>
                </div>
                <div class="relative">
                    <h4 class="font-bold text-slate-800">Free Video Library</h4>
                    <p class="text-sm text-slate-500">{{ $freeVideosCount }} Expert Masterclasses</p>
                </div>
                <i data-lucide="arrow-right" class="w-5 h-5 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition-all ml-auto relative"></i>
            </div>
        </a>
        <a href="{{ route('student.free-pdfs') }}" class="group block h-full">
            <div class="card bg-white border-slate-100 flex items-center gap-5 hover:border-emerald-600 transition-all cursor-pointer overflow-hidden relative h-full">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50/50 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0 relative">
                    <i data-lucide="file-text" class="w-7 h-7"></i>
                </div>
                <div class="relative">
                    <h4 class="font-bold text-slate-800">Resource Collections</h4>
                    <p class="text-sm text-slate-500">{{ $freePdfsCount }} Free PDF Materials</p>
                </div>
                <i data-lucide="arrow-right" class="w-5 h-5 text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all ml-auto relative"></i>
            </div>
        </a>
    </div>
</section>
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
            <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide px-2 items-stretch">
                @forelse($enrolledCourses as $course)
                <div class="w-80 flex-none group {{ $course->is_expired ? 'opacity-75 grayscale pointer-events-none' : 'cursor-pointer' }}" 
                    @if(!$course->is_expired) onclick="window.location='{{ route('student.learning', $course->id) }}'" @endif>
                    <div class="h-full flex flex-col">
                        <div class="relative rounded-3xl overflow-hidden aspect-video mb-4 shadow-sm {{ $course->is_expired ? '' : 'group-hover:shadow-xl group-hover:-translate-y-1' }} transition-all duration-300 shrink-0">
                            <img src="{{ asset('admin/uploads/courseimg/' . $course->image) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                                @if($course->is_expired)
                                    <span class="text-white text-xs font-bold px-2 py-1 bg-red-600 rounded">Expired</span>
                                @else
                                    <span class="text-white text-xs font-bold px-2 py-1 bg-blue-600 rounded">Course</span>
                                @endif
                            </div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 {{ $course->is_expired ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition-opacity">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center {{ $course->is_expired ? 'text-slate-400' : 'text-blue-600' }} shadow-xl">
                                    <i data-lucide="{{ $course->is_expired ? 'lock' : 'play' }}" class="w-6 h-6 {{ $course->is_expired ? '' : 'fill-current' }}"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-bold text-slate-800 mb-2 truncate">{{ $course->name }}</h4>
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-blue-600">Modules</span>
                                <span class="text-slate-400">{{ $course->subjects->sum(fn($s) => $s->units->count()) }} Units Total</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <div class="flex items-center justify-between text-[11px] font-bold mt-3">
                                <div class="flex items-center gap-1.5 {{ $course->is_expired ? 'text-red-500' : 'text-slate-400' }}">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    <span>Expiry Date: {{ $course->expiry_date ? $course->expiry_date->format('d M, Y') : 'N/A' }}</span>
                                </div>
                                <span class="text-blue-600">{{ $course->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2">
                                <div class="bg-{{ $course->is_expired ? 'red-500' : 'blue-600' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $course->progress_percent }}%"></div>
                            </div>
                        </div>
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
                            <i data-lucide="{{ ($latestCourse && $latestCourse->videos_completed) ? 'unlock' : 'lock' }}" class="w-4 h-4"></i>
                            <span>{{ ($latestCourse && $latestCourse->videos_completed) ? 'Exam Ready' : 'Exam Locked' }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">{{ $latestCourse ? $latestCourse->name : 'No Active Course' }}</h4>
                        <p class="text-sm text-slate-500 mb-6">
                            @if($latestCourse)
                                @if($latestCourse->videos_completed)
                                    Congratulations! You've completed the curriculum. You can now start your examination.
                                @else
                                    Complete all video lessons to unlock the exam. ({{ $latestCourse->completed_vids_count }}/{{ $latestCourse->total_vids_count }} Completed)
                                @endif
                            @else
                                Enroll in a course to unlock quizzes and exams.
                            @endif
                        </p>
                    </div>
                    @if($latestCourse)
                        @if($latestCourse->videos_completed)
                            <a href="{{ route('student.exams') }}" class="btn-primary text-center">Start Exam Now</a>
                        @else
                            <a href="{{ route('student.learning', $latestCourse->id) }}" class="w-full py-3 bg-slate-200 text-slate-500 rounded-xl font-bold text-center">Complete Course to Unlock</a>
                        @endif
                    @else
                        <a href="{{ route('courses') }}" class="btn-primary text-center">Browse Courses</a>
                    @endif
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

        <!-- Approval Progress (Pending Offline Requests) -->
        @if($pendingRequests->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-6 px-2">
                <h3 class="text-xl font-bold text-slate-800">Verification Progress</h3>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-lg border border-amber-100 uppercase tracking-widest">Action Required by Admin</span>
            </div>
            <div class="space-y-4">
                @foreach($pendingRequests as $pending)
                <div class="card bg-white border-slate-100 flex flex-col md:flex-row items-center gap-6 group hover:border-amber-200 transition-all overflow-hidden">
                    <div class="w-24 h-16 rounded-2xl overflow-hidden shrink-0 border border-slate-100">
                        <img src="{{ asset('admin/uploads/courseimg/' . $pending->image) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow min-w-0 text-center md:text-left">
                        <h4 class="font-bold text-slate-800 mb-1 truncate">
                            {{ $pending->name }}
                        </h4>
                        <p class="text-xs text-slate-500 font-medium">
                            Offline payment verification in progress
                        </p>
                    </div>

                    <div class="flex flex-col items-center md:items-end gap-2 shrink-0">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            <span class="text-xs font-black text-amber-600 uppercase tracking-widest">
                                Pending Approval
                            </span>
                        </div>

                        <p class="text-[10px] text-slate-400 font-bold bg-slate-50 px-2 py-1 rounded whitespace-nowrap">
                            Requested {{ optional($pending->pivot->created_at)->diffForHumans() ?? 'Recently' }}
                        </p>
                    </div>

                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Recent Payments -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800">Financial Records</h3>
                <a href="{{ route('student.financials') }}" class="text-xs font-bold text-blue-600 hover:underline">View All &rarr;</a>
            </div>
            <div class="card !p-0 overflow-hidden shadow-sm border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-50 bg-slate-50/30">
                                <th class="px-8 py-5">Transaction Details</th>
                                <th class="px-8 py-5 text-center">Method</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white">
                            @forelse($recentPayments as $payment)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800 mb-0.5">{{ $payment['course'] }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-mono text-slate-400">#{{ $payment['reference'] }}</span>
                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[10px] font-bold text-slate-400">Purchased: {{ $payment['date'] }}</span>
                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-1.5 rounded">Expires: {{ $payment['expiry_date'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $payment['method'] === 'ONLINE' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-50 text-slate-600 border border-slate-100' }}">
                                        {{ $payment['method'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($payment['status'] === 'Approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                                        <i data-lucide="check" class="w-3 h-3"></i> Confirmed
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest border border-amber-100">
                                        <i data-lucide="clock" class="w-3 h-3"></i> Pending
                                    </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="text-sm font-black text-slate-900">₹{{ number_format($payment['amount']) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-bold text-sm">No transaction records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('offline_success'))
<script>
    Swal.fire({
        title: 'Request Sent!',
        text: 'Admin will allow you access to the course after verifying your offline payment. Please contact the admin for faster approval.',
        icon: 'success',
        confirmButtonText: 'Got it!',
        confirmButtonColor: '#2563eb',
        customClass: {
            popup: 'rounded-[2.5rem]',
            confirmButton: 'rounded-xl px-10 py-3 font-bold'
        }
    });
</script>
@endif
@endsection