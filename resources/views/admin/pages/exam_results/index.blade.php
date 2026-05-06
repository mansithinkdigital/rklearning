@extends('admin.layouts.main')

@section('title', 'Exam Results')

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">STUDENT EXAM RESULTS</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Monitor student performance and assessment outcomes</p>
</div>
<div class="mb-6 bg-white dark:bg-[#0b1120] rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm p-6">
    <form action="{{ route('admin.exam-results.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
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
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="block px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="block px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all flex items-center gap-2 shadow-lg shadow-blue-200 dark:shadow-none">
                <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
                Apply Filters
            </button>
            @if(request()->anyFilled(['search', 'course_id', 'from_date', 'to_date']))
            <a href="{{ route('admin.exam-results.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-2">
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">All Results</h2>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course & Subject</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Score</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Date</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($results as $result)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white mb-0.5">{{ $result->user->name }}</p>
                            <p class="text-[11px] font-bold text-slate-400">{{ $result->user->email }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[12px] font-black text-slate-700 dark:text-slate-300">{{ $result->courseSubject->subject->name }}</p>
                            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">{{ $result->courseSubject->course->name }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($result->score, 1) }}%</span>
                            <span class="text-[10px] font-bold text-slate-400">({{ $result->correct_answers }}/{{ $result->total_questions }})</span>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-center">
                        <span class="text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest 
                            {{ $result->status === 'pass' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                            {{ $result->status }}
                        </span>
                    </td>
                    <td class="px-10 py-8 text-right text-[12px] font-bold text-slate-500 whitespace-nowrap">
                        {{ $result->created_at->format('d M, Y') }}
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.exam-results.show', $result->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all" title="View Details">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ route('admin.student.certificate.preview', [$result->user->id, $result->courseSubject->course->id]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all" title="Preview Certificate">
                                <i data-lucide="award" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ route('admin.student.marksheet.preview', [$result->user->id, $result->courseSubject->course->id]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all" title="Preview Marksheet">
                                <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                            </a>
                            @if($result->status === 'fail' && $result->reattempt_status !== 'allowed')
                            <form action="{{ route('admin.exam-results.allow-reattempt', $result->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-purple-700 transition-all {{ $result->reattempt_status === 'requested' ? 'ring-2 ring-purple-400 ring-offset-2' : '' }}" title="{{ $result->reattempt_status === 'requested' ? 'Reattempt Requested' : 'Allow Reattempt' }}">
                                    <i data-lucide="rotate-cw" class="w-3.5 h-3.5 {{ $result->reattempt_status === 'requested' ? 'animate-spin-slow' : '' }}"></i>
                                    @if($result->reattempt_status === 'requested')
                                        <span class="ml-1">REQUESTED</span>
                                    @endif
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-10 py-20 text-center">
                        <p class="text-sm font-bold text-slate-400">No exam results found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($results->hasPages())
    <div class="p-8 border-t border-slate-100 dark:border-slate-800">
        {{ $results->links() }}
    </div>
    @endif
</div>
@endsection