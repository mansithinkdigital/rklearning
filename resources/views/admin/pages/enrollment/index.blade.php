@extends('admin.layouts.main')

@section('title', 'Course Enrollments')

@section('content')
<div class="mb-12 text-center lg:text-left">
    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">COURSE ENROLLMENTS</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Review and approve student course access requests</p>
</div>

@if(session('success'))
<div class="mb-8 p-5 rounded-[1.5rem] bg-emerald-50 border border-emerald-100 flex items-center justify-between animate-reveal">
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </div>
        <div>
            <p class="text-[11px] font-black uppercase tracking-widest text-emerald-600 leading-tight">Success</p>
            <p class="text-sm font-bold text-emerald-800 opacity-80">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

{{-- ONLINE PAYMENTS TABLE --}}
<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden mb-12">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-indigo-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Online Payment Requests</h2>
        </div>
        <div class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl text-[10px] font-black text-indigo-500 uppercase tracking-widest">
            Count: {{ $onlineEnrollments->count() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student Details</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course Requested</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($onlineEnrollments as $enrollment)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors mb-0.5">{{ $enrollment->student_name }}</p>
                            <p class="text-[11px] font-bold text-slate-400">{{ $enrollment->student_email }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-[13px] font-bold text-slate-600 dark:text-slate-400">
                        {{ $enrollment->course_name }}
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($enrollment->receipt_file)
                                <a href="{{ asset($enrollment->receipt_file) }}" target="_blank" class="p-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all shadow-lg shadow-blue-200" title="View Receipt">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                            @endif
                            <form action="{{ route('admin.enrollments.destroy', ['user' => $enrollment->user_id, 'course' => $enrollment->course_id]) }}" method="POST" onsubmit="return confirm('Reject this request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-10 py-10 text-center text-xs font-bold text-slate-400 italic">No online requests</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- OFFLINE PAYMENTS TABLE --}}
<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-amber-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Offline Payment Requests</h2>
        </div>
        <div class="px-4 py-2 bg-amber-50 dark:bg-amber-900/20 rounded-xl text-[10px] font-black text-amber-500 uppercase tracking-widest">
            Pending Approval: {{ $offlineEnrollments->where('status', 'pending')->count() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student Details</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course Requested</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Amount</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($offlineEnrollments as $enrollment)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-amber-600 transition-colors mb-0.5">{{ $enrollment->student_name }}</p>
                            <p class="text-[11px] font-bold text-slate-400">{{ $enrollment->student_email }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-[13px] font-bold text-slate-600 dark:text-slate-400">
                        {{ $enrollment->course_name }}
                    </td>
                    <td class="px-10 py-8 text-sm font-black text-slate-900 dark:text-white">
                        ₹{{ number_format($enrollment->amount, 2) }}
                    </td>
                    <td class="px-10 py-8 text-center">
                        <span class="text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest 
                            {{ $enrollment->status === 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-600' }}">
                            {{ $enrollment->status }}
                        </span>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($enrollment->receipt_file)
                                <a href="{{ asset($enrollment->receipt_file) }}" target="_blank" class="p-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all shadow-lg shadow-blue-200" title="View Receipt">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                            @endif

                            @if($enrollment->status === 'pending')
                            <form action="{{ route('admin.enrollments.approve', ['user' => $enrollment->user_id, 'course' => $enrollment->course_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200" title="Approve Payment">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.enrollments.destroy', ['user' => $enrollment->user_id, 'course' => $enrollment->course_id]) }}" method="POST" onsubmit="return confirm('Reject this request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-10 py-10 text-center text-xs font-bold text-slate-400 italic">No offline requests</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
