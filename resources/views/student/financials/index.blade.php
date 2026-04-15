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
                    <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 bg-white">
                        <th class="px-8 py-4">Ref No.</th>
                        <th class="px-8 py-4">Description</th>
                        <th class="px-8 py-4">Method</th>
                        <th class="px-8 py-4">Date</th>
                        <th class="px-8 py-4">Amount</th>
                        <th class="px-8 py-4 text-center">Receipt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentPayments as $payment)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 font-mono text-xs text-slate-500">{{ $payment['reference'] }}</td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-bold text-slate-800">{{ $payment['description'] }}</p>
                                <p class="text-[10px] text-slate-500 font-medium">{{ $payment['course'] }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $payment['method'] === 'ONLINE' ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-600' }}">{{ $payment['method'] }}</span>
                            </td>
                            <td class="px-8 py-6 text-sm text-slate-600">{{ $payment['date'] }}</td>
                            <td class="px-8 py-6 font-bold text-slate-900">INR {{ number_format($payment['amount']) }}</td>
                            <td class="px-8 py-6 text-center">
                                <a href="{{ route('student.receipt.download', $payment['reference']) }}" class="inline-flex items-center justify-center w-10 h-10 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">
                                    <i data-lucide="download" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
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
