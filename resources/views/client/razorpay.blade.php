@extends('layouts.client')

@section('title', 'Secure Gateway - RK Institute')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .gateway-page {
        font-family: 'Outfit', sans-serif;
        background-color: #f8fafc;
    }

    .gateway-card {
        background: #ffffff;
        border: 1px solid rgba(241, 245, 249, 0.8);
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.04);
        border-radius: 40px;
    }

    .loader-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .loader-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 6px solid #2563eb;
        border-radius: 50%;
        animation: loader-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #2563eb transparent transparent transparent;
    }

    .loader-ring div:nth-child(1) { animation-delay: -0.45s; }
    .loader-ring div:nth-child(2) { animation-delay: -0.3s; }
    .loader-ring div:nth-child(3) { animation-delay: -0.15s; }

    @keyframes loader-ring {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .shimmer {
        background: linear-gradient(90deg, #f1f5f9 25%, #f8fafc 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<div class="gateway-page min-h-screen py-24 flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-md">
        <div class="gateway-card p-10 md:p-12 text-center animate-reveal">
            
            <div class="mb-10">
                <div class="loader-ring mb-6">
                    <div></div><div></div><div></div><div></div>
                </div>
                <h1 class="text-2xl font-black text-slate-900 mb-2">Secure Payment Gateway</h1>
                <p class="text-sm font-bold text-slate-400">Connecting to encrypted servers...</p>
            </div>

            <div class="bg-slate-50 rounded-3xl p-6 mb-10 border border-slate-100 text-left">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200/50">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Enrollment</span>
                    <span class="text-xs font-black text-slate-900">{{ $course->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Amount Due</span>
                    <span class="text-lg font-black text-blue-600">₹{{ number_format($course->price) }}</span>
                </div>
            </div>

            <button id="rzp-button1" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-3 group">
                Proceed to Pay
                <i class="fa fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </button>

            <div class="mt-10 flex items-center justify-center gap-4 opacity-30 grayscale grayscale-100">
                <i class="fa fa-shield-check text-xl"></i>
                <i class="fa fa-lock text-xl"></i>
                <i class="fa fa-credit-card text-xl"></i>
            </div>

            <p class="mt-8 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-relaxed">
                PCI DSS Compliant &bull; 256-bit SSL Encryption
            </p>
        </div>
        
        <p class="mt-8 text-center text-[10px] font-bold text-slate-400 leading-relaxed max-w-xs mx-auto">
            If you are not redirected within 5 seconds, please click the button above to manually initiate the payment.
        </p>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $course->price * 100 }}",
        "currency": "INR",
        "name": "RK Institute",
        "description": "Program Enrollment: {{ $course->name }}",
        "image": "{{ asset('admin/assets/images/logo-sm.png') }}",
        "handler": function(response) {
            window.location.href = "{{ route('student.courses.payment.success') }}?razorpay_payment_id=" + response.razorpay_payment_id + "&course_id={{ $course->id }}";
        },
        "prefill": {
            "name": "{{ Auth::user()->name }}",
            "email": "{{ Auth::user()->email }}",
            "contact": "{{ Auth::user()->phone }}"
        },
        "theme": {
            "color": "#2563eb"
        },
        "modal": {
            "ondismiss": function(){
                window.location.href = "{{ route('student.courses.payment.failed', ['course_id' => $course->id]) }}";
            }
        }
    };
    
    const rzp1 = new Razorpay(options);
    
    rzp1.on('payment.failed', function (response){
        window.location.href = "{{ route('student.courses.payment.failed', ['course_id' => $course->id]) }}?error=" + response.error.description;
    });

    document.getElementById('rzp-button1').onclick = function(e) {
        rzp1.open();
        e.preventDefault();
    }

    // Auto-open for a better experience
    window.onload = function() {
        setTimeout(() => {
            rzp1.open();
        }, 800);
    };
</script>
@endsection