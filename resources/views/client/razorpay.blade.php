@extends('layouts.client')

@section('title', 'Processing Payment - Rk Institute')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-20">
    <div class="max-w-md w-full p-10 bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 text-center">
        <div class="mb-8">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fa fa-spinner fa-spin text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900 mb-2">Secure Payment</h2>
            <p class="text-sm font-bold text-slate-500">Wait while we connect to Razorpay...</p>
        </div>

        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 mb-10">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-400 uppercase">Course</span>
                <span class="text-sm font-black text-slate-900">{{ $course->name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase">Amount</span>
                <span class="text-sm font-black text-blue-600">₹{{ number_format($course->price, 2) }}</span>
            </div>
        </div>
        <button id="rzp-button1" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-3">
            <i class="fa fa-credit-card"></i>
            Pay with Razorpay
        </button>
        
        <p class="mt-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            <i class="fa fa-lock mr-1"></i> Powered by Razorpay Secure
        </p>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "YOUR_RAZORPAY_KEY", // Enter the Key ID generated from the Dashboard
        "amount": "{{ $course->price * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "Rk Institute",
        "description": "Enrollment for {{ $course->name }}",
        "image": "{{ asset('logo.png') }}",
        "handler": function (response){
            // Success handler
            window.location.href = "{{ route('student.courses.payment.success') }}?payment_id=" + response.razorpay_payment_id + "&course_id={{ $course->id }}";
        },
        "prefill": {
            "name": "{{ $user->name }}",
            "email": "{{ $user->email }}",
            "contact": "{{ $user->phone }}"
        },
        "notes": {
            "address": "Rk Institute Office"
        },
        "theme": {
            "color": "#2563eb"
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
    
    // Auto-open on load
    window.onload = function() {
        // rzp1.open(); 
    };
</script>
@endsection
