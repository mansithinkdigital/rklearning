@extends('layouts.student')

@section('title', 'Fee History & Receipts')

@section('content')
<div class="max-w-6xl">
    <!-- Fee Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="card bg-slate-900 text-white border-none p-8">
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Total Course Fee</h4>
            <div class="text-3xl font-bold font-Outfit">INR {{ number_format($totalCourseFee) }}</div>
        </div>
        <div class="card bg-emerald-600 text-white border-none p-8">
            <h4 class="text-sm font-bold text-emerald-100 uppercase tracking-widest mb-1">Total Amount Paid</h4>
            <div class="text-3xl font-bold font-Outfit">INR {{ number_format($totalPaid) }}</div>
        </div>
        <div class="card bg-white border-slate-200 p-8 shadow-sm">
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Remaining Balance</h4>
            <div class="text-3xl font-bold font-Outfit text-red-600">INR {{ number_format($remainingBalance) }}</div>
        </div>
    </div>
    <!-- Payment History Table -->
    <div class="card !p-0 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800">Transaction History</h4>
                <p class="text-xs text-slate-500">Your latest fee payments are shown below.</p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="text-xs font-bold text-blue-600 px-4 py-2 bg-blue-50 rounded-lg hover:bg-blue-100 transition">Back to Dashboard</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-50 bg-slate-50/30">
                        <th class="px-8 py-5">Transaction Details</th>
                        <th class="px-8 py-5 text-center">Method</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Amount</th>
                        <th class="px-8 py-5 text-center">Receipt</th>
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
                        <td class="px-8 py-5 text-center">
                            @if($payment['status'] === 'Approved')
                            <a href="{{ route('student.receipt.download', $payment['reference']) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </a>
                            @else
                            <span class="text-[10px] font-bold text-slate-300 italic">Processing</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-bold text-sm">No transaction records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Info Box -->
    <div class="mt-8 flex items-start space-x-4 p-6 bg-yellow-50 rounded-3xl border border-yellow-100">
        <div class="w-10 h-10 bg-yellow-400 rounded-2xl flex items-center justify-center text-yellow-900"><i data-lucide="info" class="w-6 h-6"></i></div>
        <div>
            <h5 class="font-bold text-yellow-900 mb-1">Fee Payment Policy</h5>
            <p class="text-sm text-yellow-800/80 leading-relaxed">Receipts are generated automatically for online payments. For offline payments, please allow up to 24 hours for the admin to update your portal. Certification exams will only unlock after full fee clearance.</p>
        </div>
    </div>
</div>
@endsection