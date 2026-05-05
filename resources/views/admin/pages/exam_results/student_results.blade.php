@extends('admin.layouts.main')

@section('title', "Results: {$user->name}")

@section('content')
<div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">STUDENT PERFORMANCE</h1>
        <div class="flex items-center gap-3">
            <span class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Academic Report for</span>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-black tracking-widest uppercase border border-blue-100">{{ $user->name }}</span>
        </div>
    </div>
    <a href="{{ route('admin.student.index') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 dark:shadow-none">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Inventory
    </a>
</div>

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Exam History</h2>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Subject</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Score</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Date</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($results as $result)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <p class="text-[13px] font-black text-slate-900 dark:text-white mb-0.5">{{ $result->courseSubject->subject->name }}</p>
                    </td>
                    <td class="px-10 py-8">
                        <p class="text-[11px] font-bold text-blue-500 uppercase tracking-widest">{{ $result->courseSubject->course->name }}</p>
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
                            {{ strtoupper($result->status) }}
                        </span>
                    </td>
                    <td class="px-10 py-8 text-center text-[12px] font-bold text-slate-500">
                        {{ $result->created_at->format('d M, Y') }}
                    </td>
                    <td class="px-10 py-8 text-right">
                        <a href="{{ route('admin.exam-results.show', $result->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="file-x" class="w-12 h-12 text-slate-200"></i>
                            <p class="text-sm font-bold text-slate-400">No exam attempts found for this student.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
