@extends('layouts.client')

@section('title', 'Enrollment Confirmed - RK Institute')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .success-page {
        font-family: 'Outfit', sans-serif;
        background: radial-gradient(circle at top right, #f8fafc 0%, #f1f5f9 100%);
    }

    .success-card {
        background: #ffffff;
        border: 1px solid rgba(241, 245, 249, 0.8);
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.04);
        border-radius: 40px;
        position: relative;
        overflow: hidden;
    }

    .success-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #2563eb, #3b82f6, #60a5fa);
    }

    .status-icon-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 40px;
    }

    .status-icon {
        width: 100%;
        height: 100%;
        background: #f0fdf4;
        color: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
        animation: scaleIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .icon-pulse {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #10b981;
        border-radius: 50%;
        opacity: 0.2;
        animation: pulseOut 2s infinite;
    }

    @keyframes scaleIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes pulseOut {
        0% { transform: scale(1); opacity: 0.2; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #f8fafc;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .action-btn {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
    }

    .confetti-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 100;
    }
</style>

<div class="success-page min-h-screen py-24 lg:py-32 flex items-center justify-center">
    <canvas id="confetti" class="confetti-canvas"></canvas>

    <div class="container mx-auto px-6 max-w-2xl">
        <div class="success-card p-10 md:p-16 text-center animate-reveal">
            
            <div class="status-icon-wrapper">
                <div class="icon-pulse"></div>
                <div class="status-icon">
                    <i class="fa fa-check"></i>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">Payment Confirmed!</h1>
            <p class="text-lg text-slate-500 font-medium mb-12 leading-relaxed max-w-md mx-auto">
                Welcome to the institute! Your enrollment in <span class="text-blue-600 font-black">"{{ $course->name }}"</span> has been successfully processed.
            </p>

            <!-- Transaction Receipt -->
            <div class="bg-slate-50/50 rounded-3xl p-8 mb-12 border border-slate-100/50 text-left">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Enrollment Summary</h3>
                
                <div class="info-row">
                    <span class="text-sm font-bold text-slate-500">Receipt ID</span>
                    <span class="text-sm font-black text-slate-900">#{{ strtoupper(uniqid('RK')) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="text-sm font-bold text-slate-500">Student Name</span>
                    <span class="text-sm font-black text-slate-900">{{ Auth::user()->name }}</span>
                </div>

                <div class="info-row">
                    <span class="text-sm font-bold text-slate-500">Academic Program</span>
                    <span class="text-sm font-black text-slate-900">{{ $course->name }}</span>
                </div>

                <div class="info-row">
                    <span class="text-sm font-bold text-slate-500">Amount Paid</span>
                    <div class="text-right">
                        <span class="text-xs font-black text-slate-400 mr-1">INR</span>
                        <span class="text-xl font-black text-blue-600">₹{{ number_format($course->price) }}</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="grid sm:grid-cols-2 gap-6">
                <a href="{{ route('student.dashboard') }}" class="action-btn bg-slate-900 text-white font-bold py-5 rounded-2xl flex items-center justify-center gap-3">
                    <i class="fa fa-th-large text-xs opacity-50"></i>
                    Go to Dashboard
                </a>
                <a href="{{ route('student.learning', $course->id) }}" class="action-btn bg-blue-600 text-white font-bold py-5 rounded-2xl flex items-center justify-center gap-3">
                    <i class="fa fa-play text-xs"></i>
                    Start Learning
                </a>
            </div>

            <div class="mt-12 flex items-center justify-center gap-6 opacity-40 grayscale">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Razorpay_logo.svg" class="h-4" alt="Razorpay">
                <span class="w-1 h-1 rounded-full bg-slate-400"></span>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Secure Protocol v2.4</p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-xs font-bold text-slate-400 leading-relaxed max-w-sm mx-auto">
                <i class="fa fa-envelope-open-text mr-2 text-blue-400"></i>
                We've sent a digital copy of your receipt to <strong>{{ Auth::user()->email }}</strong>. Please check your inbox or spam folder.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    window.addEventListener('load', () => {
        const duration = 3 * 1000;
        const animationEnd = Date.now() + duration;
        const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
        }, 250);
    });
</script>
@endsection
