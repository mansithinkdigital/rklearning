@extends('layouts.student')

@section('title', 'Exam Portal')

@section('content')
<div class="max-w-7xl">
    <div class="mb-12">
        <h3 class="text-[34px] font-black text-slate-900 dark:text-black tracking-tight leading-none mb-3">Examination Center</h3>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Subject-wise assessments and certifications</p>
    </div>

    @if(session('success'))
    <div id="flash-success" class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div id="flash-error" class="mb-8 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center gap-3">
        <i data-lucide="x-circle" class="w-5 h-5 shrink-0"></i>
        <span class="text-sm font-bold">{{ session('error') }}</span>
    </div>
    @endif

    @php
    $completedCourses = $enrolledCourses->where('is_fully_completed', true);
    @endphp

    @if($completedCourses->isNotEmpty())
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <h4 class="text-xl font-black text-slate-900 uppercase tracking-tight">Completed Achievements</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Download your official certifications</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($completedCourses as $c)
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl p-4 sm:p-6 text-white relative overflow-hidden group shadow-lg shadow-emerald-200">

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">

                    <div class="flex-1">

                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 bg-emerald-500/30 rounded-full text-[9px] font-bold uppercase tracking-wider text-emerald-100 border border-emerald-400/20">
                                Official Credential
                            </span>
                            <span class="w-1 h-1 rounded-full bg-emerald-300 animate-pulse"></span>
                        </div>

                        <h5 class="text-lg sm:text-2xl font-bold uppercase tracking-tight mb-4 leading-snug">
                            {{ $c->name }}
                        </h5>

                        <div class="flex flex-wrap gap-2">

                            <a href="{{ route('student.certificate.download', $c->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-emerald-800 rounded-xl font-semibold text-[10px] uppercase tracking-wide hover:scale-105 transition shadow-md">
                                <i data-lucide="award" class="w-4 h-4"></i>
                                Certificate
                            </a>

                            <a href="{{ route('student.marksheet.download', $c->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-900/40 text-white border border-white/20 rounded-xl font-semibold text-[10px] uppercase tracking-wide hover:bg-emerald-900/60 transition">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                Marksheet
                            </a>
                        </div>
                    </div>
                    <!-- Smaller Icon -->
                    <div class="hidden lg:flex items-center justify-center w-24 h-24 bg-white/5 rounded-full border border-white/10">
                        <i data-lucide="shield-check" class="w-10 h-10 text-white/40"></i>
                    </div>
                </div>

                <!-- Softer Decorations -->
                <div class="absolute -right-16 -bottom-16 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($courseSubjects->isEmpty())
    <div class="p-20 bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 text-center shadow-sm">
        <div class="w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600">
            <i data-lucide="book" class="w-10 h-10"></i>
        </div>
        <h4 class="text-2xl font-black text-slate-800 dark:text-white mb-2 uppercase tracking-tight">No Subscribed Subjects</h4>
        <p class="text-slate-500 font-medium max-w-sm mx-auto mb-8">Enroll in a course to unlock project-based assessments and earn certifications.</p>
        <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-blue-200">Browse Courses</a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courseSubjects as $cs)
        @php
        $hasMcqs = $cs->mcqs->count() > 0;
        $timeLimit = $cs->time_limit > 0 ? $cs->time_limit : ($cs->mcqs->count() * 2);
        $result = $cs->result ?? null;
        $passed = $result && $result->status === 'pass';
        $attempted = $result !== null;
        @endphp
        <div class="group h-full flex flex-col bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 {{ $cs->is_expired ? 'opacity-75 grayscale' : 'hover:-translate-y-2' }}">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 bg-gradient-to-br {{ $cs->is_expired ? 'from-slate-400 to-slate-600' : ($passed ? 'from-emerald-500 to-emerald-700' : ($attempted ? 'from-red-400 to-red-600' : 'from-blue-500 to-blue-700')) }} rounded-2xl flex items-center justify-center text-white shadow-xl transition-transform group-hover:rotate-6">
                    <i data-lucide="{{ $cs->is_expired ? 'lock' : ($passed ? 'award' : ($attempted ? 'rotate-ccw' : ($hasMcqs ? 'clipboard-list' : 'lock'))) }}" class="w-6 h-6"></i>
                </div>
                @if($cs->is_expired)
                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                    Access Expired
                </span>
                @elseif($attempted)
                @if($passed)
                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                    Passed
                </span>
                @endif
                @elseif($hasMcqs)
                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-lg text-[10px] font-black uppercase tracking-widest">Active Exam</span>
                @else
                <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest">Questions Pending</span>
                @endif
            </div>

            <!-- Name -->
            <div class="mb-6">
                <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-[0.2em] mb-2">{{ $cs->course->name }}</p>
                <h4 class="text-xl font-black text-slate-900 dark:text-white tracking-tight uppercase leading-tight">{{ $cs->subject->name }}</h4>
            </div>

            <!-- Video Progress Bar -->
            <div class="mb-6">
                <div class="flex items-center justify-between text-[9px] font-black uppercase tracking-widest mb-2">
                    <span class="text-slate-400">Course Completion</span>
                    <span class="text-blue-600">{{ $cs->progress_percent }}%</span>
                </div>
                <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-1000" style="width: {{ $cs->progress_percent }}%"></div>
                </div>
            </div>

            <!-- Stats Table -->
            <div class="mt-auto mb-6 bg-slate-50 dark:bg-slate-800/60 rounded-2xl overflow-hidden">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="px-4 py-2 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail</th>
                            <th class="px-4 py-2 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        <tr>
                            <td class="px-4 py-2.5 flex items-center gap-2 text-slate-500 font-bold">
                                <i data-lucide="list-checks" class="w-3.5 h-3.5"></i> Questions
                            </td>
                            <td class="px-4 py-2.5 text-right font-black text-slate-700 dark:text-slate-200">{{ $cs->mcqs->count() }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 flex items-center gap-2 text-slate-500 font-bold">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i> Time Limit
                            </td>
                            <td class="px-4 py-2.5 text-right font-black text-slate-700 dark:text-slate-200">{{ $timeLimit }} Min</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 flex items-center gap-2 text-slate-500 font-bold">
                                <i data-lucide="target" class="w-3.5 h-3.5"></i> Total Marks
                            </td>
                            <td class="px-4 py-2.5 text-right font-black text-slate-700 dark:text-slate-200">{{ $cs->total_marks ?: '—' }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 flex items-center gap-2 text-slate-500 font-bold">
                                <i data-lucide="check-square" class="w-3.5 h-3.5"></i> Pass Marks
                            </td>
                            <td class="px-4 py-2.5 text-right font-black text-slate-700 dark:text-slate-200">{{ $cs->pass_marks ?: '—' }}</td>
                        </tr>
                        @if($attempted)
                        <tr class="bg-{{ $passed ? 'emerald' : 'red' }}-50 dark:bg-{{ $passed ? 'emerald' : 'red' }}-900/10">
                            <td class="px-4 py-2.5 flex items-center gap-2 text-{{ $passed ? 'emerald' : 'red' }}-600 font-bold">
                                <i data-lucide="bar-chart-2" class="w-3.5 h-3.5"></i> Your Score
                            </td>
                            <td class="px-4 py-2.5 text-right font-black text-{{ $passed ? 'emerald' : 'red' }}-600">{{ number_format($result->score, 1) }}%</td>
                        </tr>
                        <tr class="bg-{{ $passed ? 'emerald' : 'red' }}-50 dark:bg-{{ $passed ? 'emerald' : 'red' }}-900/10">
                            <td class="px-4 py-2.5 flex items-center gap-2 text-{{ $passed ? 'emerald' : 'red' }}-600 font-bold">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i> Submitted
                            </td>
                            <td class="px-4 py-2.5 text-right font-black text-{{ $passed ? 'emerald' : 'red' }}-600">{{ $result->created_at->format('d M Y') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Action Button -->
            @if($cs->is_expired)
            <button disabled class="w-full py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest text-center cursor-not-allowed">
                Access Expired
            </button>
            @elseif($attempted)
            <div class="space-y-3">
                <div class="w-full py-4 {{ $passed ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} rounded-2xl font-black text-[11px] uppercase tracking-widest text-center border {{ $passed ? 'border-emerald-200' : 'border-amber-200' }}">
                    {{ $passed ? '✓ Exam Passed' : 'Exam Attempted' }} — {{ $result->correct_answers }}/{{ $result->total_questions }} Correct
                </div>
                
                <div class="flex flex-col gap-2">
                    <a href="{{ route('student.exams.result', $cs->id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-colors border border-slate-200 dark:border-slate-700">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> View Detailed Result
                    </a>

                    @if(!$passed)
                        @if(!$result->reattempt_status)
                            <form action="{{ route('student.exams.request-reattempt', $cs->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center justify-center gap-2 w-full py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest transition-colors shadow-lg">
                                    <i data-lucide="help-circle" class="w-3.5 h-3.5"></i> Ask Admin for Reattempt
                                </button>
                            </form>
                        @elseif($result->reattempt_status === 'requested')
                            <button disabled class="flex items-center justify-center gap-2 w-full py-3 bg-amber-50 text-amber-600 border border-amber-200 rounded-xl font-bold text-[10px] uppercase tracking-widest cursor-not-allowed">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i> Reattempt Requested
                            </button>
                        @elseif($result->reattempt_status === 'allowed')
                            <a href="{{ route('student.exams.start', $cs->id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest transition-colors shadow-lg shadow-emerald-100">
                                <i data-lucide="play-circle" class="w-3.5 h-3.5"></i> Start Reattempt Exam
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            @elseif(!$cs->videos_completed)
            <div class="space-y-3">
                <button disabled class="w-full py-4 bg-slate-50 text-slate-400 border border-slate-200 rounded-2xl font-black text-[11px] uppercase tracking-widest text-center cursor-not-allowed flex items-center justify-center gap-2">
                    <i data-lucide="lock" class="w-3.5 h-3.5"></i> Complete Course to Unlock Exam
                </button>
                <a href="{{ route('student.learning', $cs->course_id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest transition-colors shadow-lg">
                    <i data-lucide="play" class="w-3.5 h-3.5"></i> Complete Course ({{ $cs->progress_percent }}%)
                </a>
            </div>
            @elseif($hasMcqs)
            <a href="{{ route('student.exams.start', $cs->id) }}"
                class="w-full py-4 bg-slate-900 dark:bg-blue-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest text-center group-hover:bg-blue-600 transition-colors shadow-xl shadow-blue-100 dark:shadow-none flex items-center justify-center gap-2">
                <i data-lucide="play-circle" class="w-4 h-4"></i> Start Examination
            </a>
            @else
            <button disabled class="w-full py-4 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest text-center cursor-not-allowed">
                No Questions
            </button>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Instructions -->
    <div class="mt-20 p-8 sm:p-12 bg-gradient-to-br from-slate-900 to-black rounded-[2rem] sm:rounded-[3rem] text-white relative overflow-hidden group shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1">
                <h5 class="text-2xl font-black mb-6 uppercase tracking-tight">Exam Instructions</h5>
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
                            <h6 class="font-black text-xs uppercase tracking-widest mb-1 text-white">Single Session</h6>
                            <p class="text-sm text-slate-400 font-medium leading-relaxed">Once started, do not refresh or exit. Timer keeps ticking.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center shrink-0"><i data-lucide="clock" class="w-5 h-5 text-blue-400"></i></div>
                        <div>
                            <h6 class="font-black text-xs uppercase tracking-widest mb-1 text-white">Timed Exam</h6>
                            <p class="text-sm text-slate-400 font-medium leading-relaxed">Exam auto-submits when the timer runs out.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center shrink-0"><i data-lucide="shield-check" class="w-5 h-5 text-blue-400"></i></div>
                        <div>
                            <h6 class="font-black text-xs uppercase tracking-widest mb-1 text-white">One Attempt</h6>
                            <p class="text-sm text-slate-400 font-medium leading-relaxed">Each subject exam can only be attempted once.</p>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
        ['flash-success', 'flash-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => {
                el.style.opacity = '0';
                el.style.transition = 'opacity .5s';
                setTimeout(() => el.remove(), 500);
            }, 4000);
        });
    });
</script>
@endsection