@extends('layouts.client')

@section('title', 'Payment Failed - RK Institute')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .failure-page {
        font-family: 'Outfit', sans-serif;
        background-color: #fef2f2;
    }

    .failure-card {
        background: #ffffff;
        border: 1px solid rgba(254, 226, 226, 0.8);
        box-shadow: 0 40px 100px rgba(153, 27, 27, 0.05);
        border-radius: 40px;
        position: relative;
        overflow: hidden;
    }

    .failure-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #ef4444, #f87171, #fca5a5);
    }

    .status-icon-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 32px;
    }

    .status-icon {
        width: 100%;
        height: 100%;
        background: #fef2f2;
        color: #ef4444;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        position: relative;
        z-index: 2;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }

    .action-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }
</style>

<div class="failure-page min-h-screen py-24 flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-lg">
        <div class="failure-card p-10 md:p-12 text-center animate-reveal">
            
            <div class="status-icon-wrapper">
                <div class="status-icon">
                    <i class="fa fa-times"></i>
                </div>
            </div>

            <h1 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Payment Declined</h1>
            <p class="text-slate-500 font-medium mb-10 leading-relaxed">
                We're sorry, but your transaction could not be completed. No funds were captured for this attempt.
            </p>

            <div class="bg-slate-50 rounded-3xl p-6 mb-10 border border-slate-100 text-left">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Possible Reasons</h4>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-xs font-bold text-slate-600">
                        <i class="fa fa-circle-exclamation text-red-400"></i>
                        Insufficient funds in account
                    </li>
                    <li class="flex items-center gap-3 text-xs font-bold text-slate-600">
                        <i class="fa fa-circle-exclamation text-red-400"></i>
                        Incorrect card details entered
                    </li>
                    <li class="flex items-center gap-3 text-xs font-bold text-slate-600">
                        <i class="fa fa-circle-exclamation text-red-400"></i>
                        Bank server timeout or downtime
                    </li>
                </ul>
            </div>

            <div class="grid gap-4">
                <a href="{{ route('student.courses.checkout', $course->id) }}" class="action-btn bg-blue-600 text-white font-bold py-5 rounded-2xl flex items-center justify-center gap-3 shadow-xl shadow-blue-100">
                    <i class="fa fa-redo text-xs"></i>
                    Try Payment Again
                </a>
                <a href="{{ route('contact') }}" class="action-btn bg-white border border-slate-200 text-slate-600 font-bold py-4 rounded-2xl flex items-center justify-center gap-3">
                    <i class="fa fa-headset text-xs"></i>
                    Contact Support
                </a>
            </div>

            <p class="mt-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Reference ID: #{{ strtoupper(Str::random(10)) }}
            </p>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('student.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition">
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
