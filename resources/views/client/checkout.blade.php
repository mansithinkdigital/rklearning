@extends('layouts.client')

@section('title', 'Complete Enrollment - RK Learning Hub')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #2563eb;
        --primary-soft: rgba(37, 99, 235, 0.05);
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-400: #94a3b8;
        --slate-100: #f1f5f9;
        --glass: rgba(255, 255, 255, 0.8);
    }

    .premium-page {
        font-family: 'Outfit', sans-serif;
        background-color: #fcfcfd;
        color: var(--slate-900);
    }

    .checkout-card {
        background: #ffffff;
        border: 1px solid var(--slate-100);
        box-shadow: 0 20px 50px rgba(0,0,0,0.04);
        border-radius: 32px;
    }

    .enroll-btn {
        background: var(--primary);
        color: white;
        padding: 18px 32px;
        border-radius: 16px;
        font-weight: 700;
        letter-spacing: -0.01em;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.25);
    }

    .enroll-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.35);
        background: #1d4ed8;
    }

    .enroll-btn:active {
        transform: translateY(0);
    }

    .price-display {
        background: var(--primary-soft);
        padding: 12px 20px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary);
        font-weight: 800;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid var(--slate-100);
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .animate-reveal {
        opacity: 0;
        transform: translateY(15px);
        animation: revealIn 0.6s ease forwards;
    }

    @keyframes revealIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .course-mini-thumb {
        width: 100px;
        height: 100px;
        border-radius: 20px;
        object-fit: cover;
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
    }
</style>

<div class="premium-page min-h-screen py-20 lg:py-32">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-16 animate-reveal">
            <div>
                <nav class="flex items-center gap-2 text-sm font-semibold text-slate-400 mb-4">
                    <a href="{{ route('courses.show', $course->id) }}" class="hover:text-primary transition-colors">Courses</a>
                    <i class="fa fa-chevron-right text-[10px]"></i>
                    <span class="text-slate-900">Checkout</span>
                </nav>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">Complete Enrollment</h1>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center gap-4 py-3 px-6 rounded-2xl border border-slate-100 bg-white shadow-sm">
                    <i class="fa fa-shield-check text-emerald-500 text-xl"></i>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Secure Protocol</p>
                        <p class="text-xs font-bold text-slate-900">Encrypted Gateway</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-12">
            <!-- Order Details -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- Product Card -->
                <div class="checkout-card p-8 animate-reveal" style="animation-delay: 0.1s">
                    <div class="flex flex-col md:flex-row gap-10">
                        <img src="{{ asset($course->image) }}" class="course-mini-thumb" alt="{{ $course->name }}">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="badge bg-blue-50 text-blue-600">Full Access</span>
                                <span class="badge bg-emerald-50 text-emerald-600">Certification</span>
                            </div>
                            <h2 class="text-2xl font-black text-slate-900 mb-3 leading-tight">{{ $course->name }}</h2>
                            <p class="text-slate-500 font-medium text-sm leading-relaxed">{{ \Illuminate\Support\Str::limit($course->description, 120) }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-10 pt-10 border-t border-slate-50">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Modules</p>
                            <p class="text-sm font-bold text-slate-900">{{ $course->subjects->count() }} Subjects</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Duration</p>
                            <p class="text-sm font-bold text-slate-900">Self-Paced</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Language</p>
                            <p class="text-sm font-bold text-slate-900">English/Hindi</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Enrolled</p>
                            <p class="text-sm font-bold text-slate-900">{{ $course->students->count() }}+ Scholars</p>
                        </div>
                    </div>
                </div>

                <!-- Trust signals -->
                <div class="grid sm:grid-cols-2 gap-6 animate-reveal" style="animation-delay: 0.2s">
                    <div class="checkout-card p-8 !round-3xl flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa fa-infinity text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 mb-1">Lifetime Pass</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Pay once, enjoy forever. All future curriculum updates are completely free.</p>
                        </div>
                    </div>
                    <div class="checkout-card p-8 !round-3xl flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa fa-certificate text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 mb-1">Verified Credential</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Receive a professional certificate recognized by industry leaders.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Action -->
            <div class="lg:col-span-5">
                <div class="checkout-card p-10 md:p-12 sticky top-10 animate-reveal" style="animation-delay: 0.3s">
                    <h3 class="text-lg font-black text-slate-900 mb-8 tracking-tight">Investment Summary</h3>
                    
                    <div class="space-y-2 mb-10">
                        <div class="summary-item">
                            <span class="text-sm font-bold text-slate-500">Academic Tuition</span>
                            <span class="text-sm font-black text-slate-900">₹{{ number_format($course->price) }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="text-sm font-bold text-slate-500">Digital Resource Vault</span>
                            <span class="text-xs font-black text-blue-600 uppercase tracking-widest">Included</span>
                        </div>
                        <div class="summary-item">
                            <span class="text-sm font-bold text-slate-500">Mentorship Support</span>
                            <span class="text-xs font-black text-blue-600 uppercase tracking-widest">Active</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-12">
                        <span class="text-slate-900 font-black text-lg">Total Investment</span>
                        <div class="text-right">
                            <div class="price-display">
                                <span class="text-xs">INR</span>
                                <span class="text-4xl tracking-tighter">{{ number_format($course->price) }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('student.courses.purchase', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="enroll-btn w-full flex items-center justify-center gap-3 group">
                            Enroll Now & Checkout
                            <i class="fa fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-[11px] font-bold text-slate-400 leading-relaxed">
                            <i class="fa fa-lock mr-1 text-slate-300"></i> Encrypted Transaction. No hidden charges.
                        </p>
                        <div class="flex items-center justify-center gap-4 mt-6 opacity-30">
                            <i class="fa fa-credit-card text-lg"></i>
                            <i class="fa fa-university text-lg"></i>
                            <i class="fa fa-shield-check text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
