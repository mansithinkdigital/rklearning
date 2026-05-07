@extends('admin.layouts.main')

@section('title', 'Exam Results Management')

@section('content')
<div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3 uppercase">Assessment & Academic Portal</h1>
        <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Manage reattempts and track course-wise certifications</p>
    </div>
    <div class="flex gap-4">
        <div class="px-6 py-3 bg-blue-600 rounded-2xl shadow-xl shadow-blue-200 dark:shadow-none text-white">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Total Portfolios</p>
            <p class="text-xl font-black">{{ count($completedPortfolios) }}</p>
        </div>
        <div class="px-6 py-3 bg-purple-600 rounded-2xl shadow-xl shadow-purple-200 dark:shadow-none text-white">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Reattempt Requests</p>
            <p class="text-xl font-black">{{ count($reattemptRequests) }}</p>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="flex gap-2 mb-8 bg-slate-100 dark:bg-slate-800/50 p-1.5 rounded-[1.5rem] w-fit">
    <button onclick="switchTab('portfolios')" id="btn-portfolios" class="tab-btn px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all bg-white dark:bg-slate-800 text-blue-600 shadow-sm">
        Academic Portfolios
    </button>
    <button onclick="switchTab('reattempts')" id="btn-reattempts" class="tab-btn px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all text-slate-500 hover:text-slate-700">
        Reattempt Requests @if(count($reattemptRequests) > 0) <span class="ml-1 px-1.5 py-0.5 bg-purple-100 text-purple-600 rounded-md">{{ count($reattemptRequests) }}</span> @endif
    </button>
    <button onclick="switchTab('history')" id="btn-history" class="tab-btn px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all text-slate-500 hover:text-slate-700">
        Results History
    </button>
</div>

<!-- 1. Academic Portfolios Section -->
<div id="tab-portfolios" class="tab-content bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Completed Course Portfolios</h2>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course Completed</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Completion Date</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Academic Records</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($completedPortfolios as $portfolio)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white mb-0.5 uppercase">{{ $portfolio->user->name }}</p>
                            <p class="text-[11px] font-bold text-slate-400">{{ $portfolio->user->email }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-blue-600 dark:text-blue-400 uppercase">{{ $portfolio->course->name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Full Curriculum Mastery</p>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-center text-[12px] font-black text-slate-500">
                        {{ \Carbon\Carbon::parse($portfolio->completed_at)->format('d M, Y') }}
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.student.certificate.preview', [$portfolio->user->id, $portfolio->course->id]) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 dark:shadow-none">
                                <i data-lucide="award" class="w-3.5 h-3.5"></i>
                                Certificate
                            </a>
                            <a href="{{ route('admin.student.marksheet.preview', [$portfolio->user->id, $portfolio->course->id]) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all shadow-lg shadow-amber-100 dark:shadow-none">
                                <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                Marksheet
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No completed portfolios found yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 2. Reattempt Requests Section -->
<div id="tab-reattempts" class="tab-content hidden bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-purple-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight uppercase">Pending Reattempt Permissions</h2>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Failed Assessment</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Score</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($reattemptRequests as $req)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white mb-0.5 uppercase">{{ $req->user->name }}</p>
                            <p class="text-[11px] font-bold text-slate-400">{{ $req->user->email }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[12px] font-black text-slate-700 dark:text-slate-300 uppercase">{{ $req->courseSubject->subject->name }}</p>
                            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">{{ $req->courseSubject->course->name }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-black text-red-600">{{ number_format($req->score, 1) }}%</span>
                            <span class="text-[10px] font-bold text-slate-400">({{ $req->correct_answers }}/{{ $req->total_questions }})</span>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <form action="{{ route('admin.exam-results.allow-reattempt', $req->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-purple-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-purple-700 transition-all shadow-lg shadow-purple-100 dark:shadow-none">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                Grant Reattempt Permission
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No pending reattempt requests</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 3. Results History Section -->
<div id="tab-history" class="tab-content hidden">
    <div class="mb-6 bg-white dark:bg-[#0b1120] rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm p-6">
        <form action="{{ route('admin.exam-results.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="tab" value="history">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Search Student</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Email..." class="block w-64 pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Filter by Course</label>
                <select name="course_id" class="block w-56 px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    <option value="">All Courses</option>
                    @foreach($allCourses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all flex items-center gap-2">
                    <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Subject</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Score</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($results as $result)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                        <td class="px-10 py-6">
                            <div>
                                <p class="text-[13px] font-black text-slate-900 dark:text-white mb-0.5 uppercase">{{ $result->user->name }}</p>
                                <p class="text-[11px] font-bold text-slate-400">{{ $result->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-[12px] font-black text-slate-700 dark:text-slate-300 uppercase">{{ $result->courseSubject->subject->name }}</p>
                            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">{{ $result->courseSubject->course->name }}</p>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($result->score, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest {{ $result->status === 'pass' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                                {{ $result->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-center text-[12px] font-bold text-slate-500 whitespace-nowrap">
                            {{ $result->created_at->format('d M, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-10 py-20 text-center text-slate-400 uppercase font-black text-[10px]">No history found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($results->hasPages())
        <div class="p-8 border-t border-slate-100 dark:border-slate-800">{{ $results->links() }}</div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
        // Remove active styles from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-blue-600', 'shadow-sm');
            btn.classList.add('text-slate-500');
        });

        // Show target tab content
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        // Add active styles to target button
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.add('bg-white', 'dark:bg-slate-800', 'text-blue-600', 'shadow-sm');
        activeBtn.classList.remove('text-slate-500');

        // Optional: Update URL hash or parameter
        // history.pushState(null, null, '?tab=' + tabId);
    }

    // Auto-switch to history if URL param exists
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab')) {
            switchTab(urlParams.get('tab'));
        }
    });
</script>
@endsection