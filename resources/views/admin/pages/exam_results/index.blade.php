@extends('admin.layouts.main')

@section('title', 'Exam Results')

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">STUDENT EXAM RESULTS</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Monitor student performance and assessment outcomes</p>
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
                        <a href="{{ route('admin.exam-results.show', $result->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Details
                        </a>
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