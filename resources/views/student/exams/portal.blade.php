@extends('layouts.student')
@section('title', 'Exam — ' . $courseSubject->subject->name)
@section('content')
<style>
    /* Override layout padding for exam mode */
    .option-item input[type="radio"] { display: none; }

    .option-item label {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }
    .option-item label:hover {
        border-color: #1D4ED8;
        background: #EFF6FF;
    }
    .option-item input:checked + label {
        border-color: #1D4ED8;
        background: #EFF6FF;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
    }
    .option-item input:checked + label .opt-badge {
        background: #1D4ED8;
        color: #fff;
        border-color: #1D4ED8;
    }
    .option-item input:checked + label .opt-check { display: block; }
    .option-item .opt-check { display: none; }

    .q-nav-btn {
        width: 36px; height: 36px;
        border-radius: 0.625rem;
        font-size: 11px;
        font-weight: 900;
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        cursor: pointer;
        transition: all 0.15s;
        display: flex; align-items: center; justify-content: center;
    }
    .q-nav-btn:hover { border-color: #1D4ED8; color: #1D4ED8; background: #eff6ff; }
    .q-nav-btn.answered { background: #1D4ED8; color: #fff; border-color: #1D4ED8; }
    .q-nav-btn.current { outline: 3px solid #93c5fd; outline-offset: 2px; }

    .timer-danger { animation: pulse-red 1s ease-in-out infinite; }
    @keyframes pulse-red {
        0%, 100% { background-color: #dc2626; }
        50% { background-color: #ef4444; }
    }

    /* Question card animation */
    .q-section { display: none; }
    .q-section.active { display: block; animation: fadeIn .3s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:none; } }
</style>

<form id="exam-form" action="{{ route('student.exams.submit', $courseSubject->id) }}" method="POST">
@csrf

{{-- ======================== TWO-COLUMN LAYOUT ======================== --}}
<div class="flex gap-8 items-start">

    {{-- =================== LEFT: QUESTION AREA =================== --}}
    <div class="flex-1 min-w-0">

        {{-- Exam Header Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-1">{{ $courseSubject->course->name }}</p>
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">{{ $courseSubject->subject->name }}</h2>
                <p class="text-sm text-slate-400 font-medium mt-1">{{ $courseSubject->mcqs->count() }} Questions &nbsp;·&nbsp; {{ $courseSubject->total_marks ?: '—' }} Total Marks &nbsp;·&nbsp; Pass: {{ $courseSubject->pass_marks ?: '—' }}</p>
            </div>
            {{-- Mobile Timer --}}
            <div id="timer-mobile" class="sm:hidden flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-2xl font-black tracking-widest">
                <i data-lucide="clock" class="w-4 h-4 text-blue-400"></i>
                <span id="timer-display-m" class="tabular-nums text-lg">{{ str_pad($timeLimit, 2, '0', STR_PAD_LEFT) }}:00</span>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6 flex items-center gap-4">
            <div class="flex-1 h-3 bg-slate-100 rounded-full overflow-hidden">
                <div id="progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-blue-700 rounded-full transition-all duration-500" style="width:0%"></div>
            </div>
            <span id="progress-label" class="text-[11px] font-black text-slate-500 uppercase tracking-widest whitespace-nowrap min-w-max">0 / {{ $courseSubject->mcqs->count() }} Answered</span>
        </div>

        {{-- Question Sections (one at a time) --}}
        @foreach($courseSubject->mcqs as $index => $mcq)
        @php $options = is_array($mcq->options) ? $mcq->options : json_decode($mcq->options, true); @endphp
        <div id="qsec-{{ $index }}" class="q-section {{ $index === 0 ? 'active' : '' }}">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8">

                {{-- Question Label --}}
                <div class="flex items-start gap-4 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-sm shrink-0 shadow-lg shadow-blue-200">
                        {{ $index + 1 }}
                    </div>
                    <div class="pt-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Question {{ $index + 1 }} of {{ $courseSubject->mcqs->count() }}</p>
                        <p class="text-lg font-bold text-slate-800 leading-relaxed">{{ $mcq->question }}</p>
                    </div>
                </div>

                {{-- Options --}}
                <div class="space-y-3 ml-14">
                    @foreach($options as $optKey => $optVal)
                    @php
                        $label = is_string($optKey) ? strtoupper($optKey) : chr(65 + $optKey);
                        $val = trim($optVal);
                        $uid = "mcq_{$mcq->id}_{$optKey}";
                    @endphp
                    <div class="option-item">
                        <input type="radio"
                               id="{{ $uid }}"
                               name="answers[{{ $mcq->id }}]"
                               value="{{ $val }}"
                               data-qid="{{ $mcq->id }}"
                               data-qidx="{{ $index }}"
                               onchange="onOptionSelect(this)">
                        <label for="{{ $uid }}">
                            <div class="opt-badge w-9 h-9 rounded-lg border-2 border-slate-200 flex items-center justify-center text-xs font-black text-slate-500 shrink-0 transition-all">
                                {{ $label }}
                            </div>
                            <span class="text-[15px] font-semibold text-slate-700 leading-snug flex-1">{{ $val }}</span>
                            <i data-lucide="check-circle" class="opt-check w-5 h-5 text-blue-600 shrink-0"></i>
                        </label>
                    </div>
                    @endforeach
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                    <button type="button" onclick="goToQuestion({{ $index - 1 }})"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-[12px] font-black uppercase tracking-widest transition-all
                        {{ $index === 0 ? 'bg-slate-100 text-slate-300 cursor-not-allowed' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        {{ $index === 0 ? 'disabled' : '' }}>
                        <i data-lucide="chevron-left" class="w-4 h-4"></i> Prev
                    </button>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $index + 1 }} / {{ $courseSubject->mcqs->count() }}</span>
                    @if($index < $courseSubject->mcqs->count() - 1)
                        <button type="button" onclick="goToQuestion({{ $index + 1 }})"
                            class="flex items-center gap-2 px-5 py-3 bg-blue-600 text-white rounded-2xl text-[12px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                            Next <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    @else
                        <button type="button" onclick="confirmSubmit()"
                            class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl text-[12px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg">
                            <i data-lucide="send" class="w-4 h-4"></i> Submit
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>{{-- /left --}}

    {{-- =================== RIGHT: SIDEBAR PANEL =================== --}}
    <div class="hidden sm:flex flex-col gap-6" style="width:280px;min-width:280px;">

        {{-- Timer Card --}}
        <div id="timer-card" class="bg-slate-900 rounded-[2rem] p-6 text-white text-center shadow-xl">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="clock" class="w-7 h-7 text-blue-400"></i>
            </div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Time Remaining</p>
            <div id="timer-display" class="text-4xl font-black tabular-nums tracking-widest mb-2">
                {{ str_pad($timeLimit, 2, '0', STR_PAD_LEFT) }}:00
            </div>
            <div id="timer-bar-wrap" class="h-2 bg-white/10 rounded-full overflow-hidden mt-3">
                <div id="timer-bar" class="h-full bg-blue-500 rounded-full transition-all duration-1000" style="width:100%"></div>
            </div>
        </div>

        {{-- Progress Summary --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Progress</p>
            <div class="flex items-end justify-between mb-2">
                <span id="side-answered" class="text-3xl font-black text-slate-900">0</span>
                <span class="text-sm font-bold text-slate-400">/ {{ $courseSubject->mcqs->count() }}</span>
            </div>
            <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                <div id="side-progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-blue-700 rounded-full transition-all duration-500" style="width:0%"></div>
            </div>
            <p class="text-xs font-bold text-slate-400 mt-2">Questions Answered</p>
        </div>

        {{-- Question Navigator --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Jump to Question</p>
            <div class="flex flex-wrap gap-2">
                @foreach($courseSubject->mcqs as $index => $mcq)
                <button type="button"
                    id="qnav-{{ $index }}"
                    class="q-nav-btn {{ $index === 0 ? 'current' : '' }}"
                    onclick="goToQuestion({{ $index }})">
                    {{ $index + 1 }}
                </button>
                @endforeach
            </div>
            <div class="mt-4 flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm bg-[#1D4ED8]"></div> Answered</div>
                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-sm border-2 border-slate-200"></div> Not Yet</div>
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="button" onclick="confirmSubmit()"
            class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-2">
            <i data-lucide="send" class="w-4 h-4"></i>
            Submit Examination
        </button>

    </div>{{-- /right sidebar --}}

</div>{{-- /flex --}}
</form>

{{-- =================== CONFIRM MODAL =================== --}}
<div id="confirm-modal" class="fixed inset-0 z-[200] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl p-10 text-center">
        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="send" class="w-9 h-9 text-blue-600"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Submit Exam?</h3>
        <p class="text-slate-500 text-sm font-medium mb-8">
            You've answered <span id="conf-answered" class="font-black text-slate-800">0</span> of
            <strong>{{ $courseSubject->mcqs->count() }}</strong> questions.<br>
            <span class="text-red-500 font-bold">This cannot be undone.</span>
        </p>
        <div class="flex gap-4">
            <button type="button" onclick="closeConfirm()" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Cancel
            </button>
            <button type="button" onclick="doSubmit()" id="final-submit-btn"
                class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i> Confirm & Submit
            </button>
        </div>
    </div>
</div>

{{-- =================== TIMEOUT MODAL =================== --}}
<div id="timeout-modal" class="fixed inset-0 z-[200] hidden">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl p-10 text-center">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="clock" class="w-9 h-9 text-red-500"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Time's Up!</h3>
        <p class="text-slate-500 text-sm font-medium mb-6">Your exam is being submitted automatically.</p>
        <div class="flex justify-center">
            <div class="px-6 py-3 bg-red-50 text-red-600 font-black text-sm rounded-xl animate-pulse">Submitting…</div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const TOTAL_SECS   = {{ ($timeLimit ?? 30) * 60 }};
    const TOTAL_QS     = {{ $courseSubject->mcqs->count() }};
    let   remaining    = TOTAL_SECS;
    let   answered     = new Set();
    let   currentQ     = 0;
    let   submitted    = false;
    let   timerInt     = null;

    // ─── TIMER ────────────────────────────────────────────
    function startTimer() {
        renderTimer(remaining);
        timerInt = setInterval(() => {
            remaining--;
            renderTimer(remaining);
            if (remaining <= 0) { clearInterval(timerInt); autoSubmit(); }
        }, 1000);
    }

    function renderTimer(secs) {
        const m = String(Math.floor(secs / 60)).padStart(2,'0');
        const s = String(secs % 60).padStart(2,'0');
        const text = m + ':' + s;

        const disp = document.getElementById('timer-display');
        const dispM = document.getElementById('timer-display-m');
        if (disp)  disp.textContent  = text;
        if (dispM) dispM.textContent = text;

        // Bar fill
        const bar  = document.getElementById('timer-bar');
        const card = document.getElementById('timer-card');
        const pct  = (secs / TOTAL_SECS) * 100;
        if (bar) bar.style.width = pct + '%';

        if (secs <= 60) {
            if (bar) bar.className = bar.className.replace(/bg-\S+/g, '') + ' h-full bg-red-500 rounded-full transition-all duration-1000';
            if (card) { card.classList.add('timer-danger'); card.classList.remove('bg-slate-900'); }
        } else if (secs <= 300) {
            if (bar) bar.className = bar.className.replace(/bg-\S+/g, '') + ' h-full bg-amber-400 rounded-full transition-all duration-1000';
        }
    }

    // ─── QUESTION NAVIGATION ──────────────────────────────
    function goToQuestion(idx) {
        if (idx < 0 || idx >= TOTAL_QS) return;

        // Hide current
        document.querySelectorAll('.q-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.q-nav-btn').forEach(b => b.classList.remove('current'));

        // Show target
        const sec = document.getElementById('qsec-' + idx);
        const nav = document.getElementById('qnav-' + idx);
        if (sec) sec.classList.add('active');
        if (nav) nav.classList.add('current');

        currentQ = idx;

        // Scroll top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    // ─── OPTION SELECTION ─────────────────────────────────
    function onOptionSelect(input) {
        const idx = parseInt(input.dataset.qidx);
        answered.add(input.dataset.qid);

        // Mark nav button answered
        const navBtn = document.getElementById('qnav-' + idx);
        if (navBtn) navBtn.classList.add('answered');

        updateProgress();
    }

    function updateProgress() {
        const count = answered.size;
        const pct   = TOTAL_QS > 0 ? (count / TOTAL_QS * 100) : 0;

        document.getElementById('progress-bar').style.width   = pct + '%';
        document.getElementById('progress-label').textContent = count + ' / ' + TOTAL_QS + ' Answered';
        document.getElementById('side-answered').textContent  = count;
        document.getElementById('side-progress-bar').style.width = pct + '%';
        document.getElementById('conf-answered').textContent  = count;
    }

    // ─── SUBMIT FLOW ─────────────────────────────────────
    function confirmSubmit() {
        if (submitted) return;
        document.getElementById('confirm-modal').classList.remove('hidden');
    }
    function closeConfirm() {
        document.getElementById('confirm-modal').classList.add('hidden');
    }

    function doSubmit() {
        if (submitted) return;
        submitted = true;
        clearInterval(timerInt);
        closeConfirm();

        const btn = document.getElementById('final-submit-btn');
        btn.innerHTML = '<svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> Submitting…';
        btn.disabled = true;

        const form = document.getElementById('exam-form');
        const fd   = new FormData(form);

        fetch(form.action, {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': fd.get('_token'), 'Accept': 'application/json' },
            body   : fd
        })
        .then(r => r.json())
        .then(d => { window.location.href = d.redirect || '{{ route("student.exams") }}'; })
        .catch(() => form.submit());
    }

    function autoSubmit() {
        if (submitted) return;
        submitted = true;
        document.getElementById('timeout-modal').classList.remove('hidden');
        setTimeout(() => {
            const form = document.getElementById('exam-form');
            const fd   = new FormData(form);
            fetch(form.action, {
                method : 'POST',
                headers: { 'X-CSRF-TOKEN': fd.get('_token'), 'Accept': 'application/json' },
                body   : fd
            })
            .then(r => r.json())
            .then(d => { window.location.href = d.redirect || '{{ route("student.exams") }}'; })
            .catch(() => form.submit());
        }, 2000);
    }

    // ─── INIT ────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
        // startTimer(); // Moved to startExamNow()
        window.addEventListener('beforeunload', e => {
            if (!submitted && !document.getElementById('instruction-overlay').classList.contains('hidden')) {
                // If they haven't started yet, allow leaving without warning
                return;
            }
            if (!submitted) { e.preventDefault(); e.returnValue = 'Exam is in progress. Leave?'; }
        });
    });

    function startExamNow() {
        document.getElementById('instruction-overlay').classList.add('hidden');
        startTimer();
    }
</script>

{{-- =================== INSTRUCTION OVERLAY =================== --}}
<div id="instruction-overlay" class="fixed inset-0 z-[300] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"></div>
    <div class="relative w-full max-w-3xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        {{-- Header --}}
        <div class="bg-slate-900 p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Examination Portal</p>
                <h3 class="text-3xl font-black uppercase tracking-tight">{{ $courseSubject->subject->name }}</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Please read all instructions carefully before starting.</p>
            </div>
            <i data-lucide="file-text" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5 -rotate-12"></i>
        </div>

        {{-- Body --}}
        <div class="p-8 md:p-10 max-h-[60vh] overflow-y-auto custom-scrollbar">
            <div class="space-y-8">
                {{-- General --}}
                <section>
                    <h4 class="flex items-center gap-2 text-slate-900 font-black text-sm uppercase tracking-widest mb-4">
                        <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"><i data-lucide="info" class="w-4 h-4"></i></span>
                        General Instructions
                    </h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0"></i>
                            <span>There will be total <strong class="text-slate-900">{{ $courseSubject->mcqs->count() }} Questions</strong>.</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0"></i>
                            <span>Duration will be of <strong class="text-slate-900">{{ $timeLimit }} Minutes</strong>.</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0"></i>
                            <span>The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available to you for completing the examination.</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0"></i>
                            <span>When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.</span>
                        </li>
                    </ul>
                </section>

                {{-- Careful --}}
                <section>
                    <h4 class="flex items-center gap-2 text-slate-900 font-black text-sm uppercase tracking-widest mb-4">
                        <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center"><i data-lucide="alert-circle" class="w-4 h-4"></i></span>
                        Read Carefully
                    </h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="help-circle" class="w-4 h-4 text-blue-500 mt-0.5 shrink-0"></i>
                            <span>This test comprises of multiple-choice questions (MCQs).</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="help-circle" class="w-4 h-4 text-blue-500 mt-0.5 shrink-0"></i>
                            <span>Each question will have only one of the available options as the correct answer.</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="help-circle" class="w-4 h-4 text-blue-500 mt-0.5 shrink-0"></i>
                            <span>You are advised not to close the browser window before submitting the test.</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <i data-lucide="help-circle" class="w-4 h-4 text-blue-500 mt-0.5 shrink-0"></i>
                            <span>In case, if the test does not load completely or becomes unresponsive, click on browser's refresh button to reload.</span>
                        </li>
                    </ul>
                </section>

                {{-- Marking --}}
                <section>
                    <h4 class="flex items-center gap-2 text-slate-900 font-black text-sm uppercase tracking-widest mb-4">
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i data-lucide="target" class="w-4 h-4"></i></span>
                        Marking Scheme
                    </h4>
                    @php
                        $marksPerQ = $courseSubject->mcqs->count() > 0 ? ($courseSubject->total_marks / $courseSubject->mcqs->count()) : 0;
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl">
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Correct Answer</p>
                            <p class="text-lg font-black text-emerald-700">+{{ number_format($marksPerQ, 1) }} Mark</p>
                        </div>
                        <div class="p-4 bg-red-50 border border-red-100 rounded-2xl">
                            <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Wrong Answer</p>
                            <p class="text-lg font-black text-red-700">0.0 Mark</p>
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Un-attempted</p>
                            <p class="text-lg font-black text-slate-700">0.0 Mark</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- Footer --}}
        <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <p class="text-xs text-slate-500 font-bold leading-tight">By clicking start, you agree to follow <br> all examination rules and regulations.</p>
            </div>
            <button type="button" onclick="startExamNow()" class="w-full md:w-auto px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 hover:scale-105 transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-3">
                I am ready to begin
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection
