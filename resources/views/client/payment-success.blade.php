@extends('layouts.client')

@section('title', 'Payment Successful - Rk Institute')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-20 px-6">
    <div class="max-w-xl w-full text-center">
        <div class="mb-12 relative">
            <div class="w-32 h-32 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-emerald-100 animate-bounce">
                <i class="fa fa-check text-5xl"></i>
            </div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-emerald-400 opacity-5 rounded-full blur-3xl"></div>
        </div>
        <h1 class="text-4xl font-black text-slate-900 mb-4 tracking-tight">Payment Successful!</h1>
        <p class="text-lg text-slate-500 font-medium mb-12">Congratulations! Your enrollment in <span class="text-slate-900 font-bold">"{{ $course->name }}"</span> has been confirmed. You now have full access to the course materials.</p>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl mb-12">
            <div class="flex items-center justify-between py-4 border-b border-slate-50">
                <span class="text-sm font-bold text-slate-400">Transaction ID</span>
                <span class="text-sm font-black text-slate-900">#{{ strtoupper(uniqid('RK')) }}</span>
            </div>
            <div class="flex items-center justify-between py-4 border-b border-slate-50">
                <span class="text-sm font-bold text-slate-400">Course Name</span>
                <span class="text-sm font-black text-slate-900">{{ $course->name }}</span>
            </div>
            <div class="flex items-center justify-between py-4">
                <span class="text-sm font-bold text-slate-400">Total Amount</span>
                <span class="text-sm font-black text-emerald-600">₹{{ number_format($course->price, 2) }}</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('student.dashboard') }}" class="flex-1 bg-slate-900 text-white font-black py-5 rounded-2xl hover:bg-black transition-all shadow-xl shadow-slate-200">
                Go to Dashboard
            </a>
            <a href="{{ route('student.learning', $course->id) }}" class="flex-1 bg-blue-600 text-white font-black py-5 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-200">
                Start Learning Now
            </a>
        </div>
        
        <p class="mt-12 text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center justify-center gap-2">
            <i class="fa fa-envelope"></i> Confirmation email has been sent to your inbox
        </p>
    </div>
</div>
@endsection
