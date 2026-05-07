@extends('layouts.student')

@section('title', 'Exam Analysis - ' . $courseSubject->subject->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-12">
        <a href="{{ route('student.exams') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-blue-600 transition-colors mb-6 font-bold text-xs uppercase tracking-widest">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Exams
        </a>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-[0.2em] mb-2">{{ $courseSubject->course->name }}</p>
                <h3 class="text-[34px] font-black text-black dark:text-black tracking-tight leading-none">{{ $courseSubject->subject->name }} - Analysis</h3>
            </div>
            <div class="px-6 py-3 {{ $result->status === 'pass' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} rounded-2xl border {{ $result->status === 'pass' ? 'border-emerald-100' : 'border-red-100' }} flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl {{ $result->status === 'pass' ? 'bg-emerald-600' : 'bg-red-600' }} flex items-center justify-center text-white shadow-lg">
                    <i data-lucide="{{ $result->status === 'pass' ? 'award' : 'alert-circle' }}" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Final Status</p>
                    <p class="text-sm font-black uppercase tracking-tight">{{ strtoupper($result->status) }} — {{ number_format($result->score, 1) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Questions</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $result->total_questions }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Correct Answers</p>
            <p class="text-2xl font-black text-emerald-600">{{ $result->correct_answers }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Wrong Answers</p>
            <p class="text-2xl font-black text-red-600">{{ $result->total_questions - $result->correct_answers }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">Accuracy</p>
            <p class="text-2xl font-black text-blue-600">{{ $result->total_questions > 0 ? round(($result->correct_answers / $result->total_questions) * 100) : 0 }}%</p>
        </div>
    </div>

    <!-- Questions Detailed Analysis -->
    <div class="space-y-8">
        @if(!$result->reattempt_status || $result->reattempt_status === 'none')
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-black text-slate-900 dark:text-black uppercase tracking-tight">Question-wise Breakdown</h4>
            <div class="flex items-center gap-4 text-xs font-bold">
                <span class="flex items-center gap-1.5 text-emerald-600"><span class="w-2 h-2 rounded-full bg-emerald-600"></span> Correct</span>
                <span class="flex items-center gap-1.5 text-red-600"><span class="w-2 h-2 rounded-full bg-red-600"></span> Incorrect</span>
                <span class="flex items-center gap-1.5 text-slate-400"><span class="w-2 h-2 rounded-full bg-slate-400"></span> Unanswered</span>
            </div>
        </div>

        @foreach($courseSubject->mcqs as $index => $mcq)
        @php
        $studentAnswer = $result->student_answers[$mcq->id] ?? null;
        $isCorrect = $studentAnswer == $mcq->answer;
        $unanswered = is_null($studentAnswer);
        @endphp
        <div class="p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border {{ $unanswered ? 'border-slate-100 dark:border-slate-800' : ($isCorrect ? 'border-emerald-100 bg-emerald-50/20' : 'border-red-100 bg-red-50/20') }} shadow-sm">
            <div class="flex items-start gap-6">
                <div class="w-12 h-12 shrink-0 rounded-2xl flex items-center justify-center font-black text-lg shadow-sm
                        {{ $unanswered ? 'bg-slate-100 text-slate-400' : ($isCorrect ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600') }}">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $unanswered ? 'text-slate-400' : ($isCorrect ? 'text-emerald-500' : 'text-red-500') }}">
                            {{ $unanswered ? 'Not Answered' : ($isCorrect ? 'Correct Answer' : 'Incorrect Answer') }}
                        </span>
                        @if(!$isCorrect && !$unanswered)
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded">Correct target: Option {{ strtoupper($mcq->answer) }}</span>
                        @endif
                    </div>
                    <h5 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 leading-relaxed">{{ $mcq->question }}</h5>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($mcq->options as $idx => $optionText)
                        @php
                        $isThisCorrect = $optionText == $mcq->answer;
                        $isThisStudentSelection = $studentAnswer == $optionText;

                        $style = 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400';
                        $icon = null;

                        if ($isThisCorrect) {
                        $style = 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/10 text-emerald-700 dark:text-emerald-400';
                        $icon = 'check-circle';
                        } elseif ($isThisStudentSelection && !$isCorrect) {
                        $style = 'border-red-500 bg-red-50 dark:bg-red-900/10 text-red-700 dark:text-red-400';
                        $icon = 'x-circle';
                        }
                        @endphp
                        <div class="px-5 py-4 rounded-xl border-2 {{ $style }} flex items-center justify-between gap-3 text-sm font-bold transition-all">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black uppercase {{ $isThisCorrect ? 'bg-emerald-100 text-emerald-600' : ($isThisStudentSelection ? 'bg-red-100 text-red-600' : '') }}">
                                    {{ chr(65 + $idx) }}
                                </span>
                                <div class="flex flex-col">
                                    <span>{{ $optionText }}</span>
                                    @if($isThisStudentSelection)
                                        <span class="text-[9px] uppercase tracking-tighter {{ $isCorrect ? 'text-emerald-500' : 'text-red-500' }}">Your Selection</span>
                                    @endif
                                    @if($isThisCorrect && !$isCorrect)
                                        <span class="text-[9px] uppercase tracking-tighter text-emerald-500">Correct Answer</span>
                                    @endif
                                </div>
                            </div>
                            @if($icon)
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 shrink-0"></i>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="p-12 bg-amber-50 border border-amber-100 rounded-[3rem] text-center">
            <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="lock" class="w-10 h-10"></i>
            </div>
            <h4 class="text-2xl font-black text-amber-900 uppercase tracking-tight mb-2">Answer Sheet Hidden</h4>
            <p class="text-amber-700 font-medium max-w-md mx-auto">Detailed analysis is hidden while a reattempt is requested or authorized to maintain examination integrity.</p>
        </div>
        @endif
    </div>

    @if($isCourseCompleted)
    <div class="mt-12 p-8 sm:p-12 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-[3rem] text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-4 py-1 bg-emerald-500/30 rounded-full text-[10px] font-black uppercase tracking-[0.2em] text-emerald-100 border border-emerald-400/20">Course Fully Completed</span>
                    <i data-lucide="party-popper" class="w-5 h-5 text-emerald-300"></i>
                </div>
                <h5 class="text-3xl font-black uppercase tracking-tight mb-4">Congratulations!</h5>
                <p class="text-sm text-emerald-100 font-medium mb-8 max-w-md">You have successfully passed all examinations for <b>{{ $course->name }}</b>. Your official credentials are now ready for download.</p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('student.certificate.download', $course->id) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-emerald-800 rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl">
                        <i data-lucide="award" class="w-5 h-5"></i> Download Certificate
                    </a>
                    <a href="{{ route('student.marksheet.download', $course->id) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-emerald-900/40 text-white border border-white/20 backdrop-blur-md rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-900/60 transition-all">
                        <i data-lucide="file-text" class="w-5 h-5"></i> Official Marksheet
                    </a>
                </div>
            </div>
            <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center border border-white/20 backdrop-blur-sm">
                <i data-lucide="shield-check" class="w-16 h-16 text-white/40"></i>
            </div>
        </div>
        <!-- Decorative -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-[100px]"></div>
    </div>
    @endif

    <div class="mt-12 text-center pb-20">
        <a href="{{ route('student.exams') }}" class="inline-flex items-center gap-2 px-10 py-5 bg-slate-900 text-white rounded-[2rem] font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-2xl">
            Return to Dashboard
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection