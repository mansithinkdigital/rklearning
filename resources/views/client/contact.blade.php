@extends('layouts.client')

@section('title', 'Contact Us - RK Institute of Commerce')

@section('styles')
<style>
    :root{
        --rk-primary:#0f2d62;
        --rk-secondary:#0f172a;
        --rk-accent:#d4a437;
        --rk-border:#e2e8f0;
    }

    .contact-hero{
        background:
            linear-gradient(rgba(2,6,23,.88),rgba(15,23,42,.92)),
            url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80');
        background-size:cover;
        background-position:center;
        position:relative;
    }

    .contact-hero::before{
        content:'';
        position:absolute;
        inset:0;
        background:
            radial-gradient(circle at top left, rgba(59,130,246,.18), transparent 30%),
            radial-gradient(circle at bottom right, rgba(245,158,11,.18), transparent 25%);
    }

    .contact-card{
        transition:all .35s ease;
        border:1px solid var(--rk-border);
    }

    .contact-card:hover{
        transform:translateY(-10px);
        box-shadow:0 25px 60px rgba(15,23,42,.08);
        border-color:#1e3a8a;
    }

    .input-field{
        width:100%;
        padding:16px 20px;
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:16px;
        font-weight:500;
        transition:.3s ease;
    }

    .input-field:focus{
        background:#fff;
        border-color:#1e3a8a;
        box-shadow:0 0 0 4px rgba(30,58,138,.08);
        outline:none;
    }

    .social-btn{
        width:58px;
        height:58px;
        border-radius:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:rgba(255,255,255,.06);
        color:#fff;
        transition:.3s ease;
        border:1px solid rgba(255,255,255,.08);
    }

    .social-btn:hover{
        background:#d4a437;
        color:#0f172a;
        transform:translateY(-5px);
    }

    .section-tag{
        letter-spacing:.18em;
    }

    .glass-card{
        background:rgba(255,255,255,.05);
        border:1px solid rgba(255,255,255,.08);
        backdrop-filter:blur(14px);
    }

    .info-icon{
        width:72px;
        height:72px;
        border-radius:24px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:30px;
    }
</style>
@endsection

@section('content')

<main class="overflow-hidden">

    <!-- HERO -->
    <section class="contact-hero py-28 md:py-36 overflow-hidden">

        <div class="container mx-auto px-6 relative z-10 text-center">

            <p class="section-tag text-sm uppercase font-black text-amber-400 mb-5">
                Contact RK Institute
            </p>

            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                Get In
                <span class="text-amber-400">Touch</span>
            </h1>

            <p class="text-slate-300 text-xl max-w-3xl mx-auto leading-relaxed">
                Have questions about admissions, courses, fees, or career guidance?
                Our team is here to help you begin your professional journey.
            </p>

        </div>

    </section>

    <!-- CONTACT INFO -->
    <section class="py-24 bg-white relative -mt-16 z-20">

        <div class="container mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- PHONE -->
                <div class="contact-card bg-white rounded-[2rem] p-10 text-center shadow-xl shadow-slate-100">

                    <div class="info-icon bg-blue-50 text-blue-700 mx-auto mb-8">
                        <i class="fa fa-phone-volume"></i>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 mb-4">
                        Call Us
                    </h3>

                    <p class="text-slate-500 mb-6 font-medium">
                        Mon - Sat : 9:00 AM to 7:00 PM
                    </p>

                    <a href="tel:+918888937680"
                       class="text-2xl font-black text-slate-900 hover:text-blue-700 transition">
                        +91 88 88 93 76 80
                    </a>

                </div>

                <!-- EMAIL -->
                <div class="contact-card bg-white rounded-[2rem] p-10 text-center shadow-xl shadow-slate-100">

                    <div class="info-icon bg-amber-50 text-amber-500 mx-auto mb-8">
                        <i class="fa fa-envelope-open-text"></i>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 mb-4">
                        Email Us
                    </h3>

                    <p class="text-slate-500 mb-6 font-medium">
                        We usually respond within 24 hours
                    </p>

                    <a href="mailto:Rkinstitute.cm@gmail.com"
                       class="text-lg font-black text-slate-900 hover:text-blue-700 transition break-all">
                        Rkinstitute.cm@gmail.com
                    </a>

                </div>

                <!-- LOCATION -->
                <div class="contact-card bg-white rounded-[2rem] p-10 text-center shadow-xl shadow-slate-100">

                    <div class="info-icon bg-green-50 text-green-600 mx-auto mb-8">
                        <i class="fa fa-location-dot"></i>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 mb-4">
                        Visit Institute
                    </h3>

                    <p class="text-slate-500 mb-6 font-medium">
                        RK Institute of Commerce
                    </p>

                    <p class="text-lg font-bold text-slate-900 leading-relaxed">
                        Maharashtra, India
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- CONTACT FORM -->
    <section class="py-28 bg-slate-50">

        <div class="container mx-auto px-6">

            <div class="bg-white rounded-[3rem] overflow-hidden border border-slate-100 shadow-2xl shadow-slate-200">

                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- FORM SIDE -->
                    <div class="p-10 md:p-20">

                        <p class="section-tag text-sm uppercase font-black text-amber-500 mb-4">
                            Admission Inquiry
                        </p>

                        <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6">
                            Send Us A Message
                        </h2>

                        <p class="text-slate-500 text-lg leading-relaxed mb-12">
                            Fill out the form below and our admissions team
                            will contact you shortly with complete details.
                        </p>

                        <form action="#" method="POST" class="space-y-6">

                            @csrf

                            <div class="grid md:grid-cols-2 gap-6">

                                <div>
                                    <label class="text-sm font-bold text-slate-900 block mb-3">
                                        Full Name
                                    </label>

                                    <input type="text"
                                           class="input-field"
                                           placeholder="Enter your name">
                                </div>

                                <div>
                                    <label class="text-sm font-bold text-slate-900 block mb-3">
                                        Phone Number
                                    </label>

                                    <input type="text"
                                           class="input-field"
                                           placeholder="+91 00000 00000">
                                </div>

                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-900 block mb-3">
                                    Email Address
                                </label>

                                <input type="email"
                                       class="input-field"
                                       placeholder="Enter your email">
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-900 block mb-3">
                                    Interested Course
                                </label>

                                <select class="input-field cursor-pointer">

                                    <option>Accounting</option>
                                    <option>Costing</option>
                                    <option>Income Tax</option>
                                    <option>GST</option>
                                    <option>Computerized Accounting</option>

                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-900 block mb-3">
                                    Message
                                </label>

                                <textarea rows="5"
                                          class="input-field"
                                          placeholder="Write your message here..."></textarea>
                            </div>

                            <div class="pt-4">

                                <button type="submit"
                                        class="w-full py-5 bg-slate-900 hover:bg-blue-700 text-white font-black rounded-2xl transition shadow-xl shadow-slate-200">
                                    Submit Inquiry
                                </button>

                            </div>

                        </form>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="bg-slate-950 p-10 md:p-20 text-white flex flex-col justify-between relative overflow-hidden">

                        <div class="absolute -top-20 -right-20 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl"></div>

                        <div class="relative z-10">

                            <p class="section-tag text-sm uppercase font-black text-amber-400 mb-4">
                                Stay Connected
                            </p>

                            <h2 class="text-4xl md:text-5xl font-black mb-8">
                                Follow Us
                            </h2>

                            <p class="text-slate-400 text-lg leading-relaxed mb-14">
                                Stay updated with course launches, results,
                                student achievements, and institute updates.
                            </p>

                            <div class="space-y-10">

                                <!-- INSTAGRAM -->
                                <div class="flex items-center gap-6">

                                    <a href="https://www.instagram.com/rk_institute_1"
                                       target="_blank"
                                       class="social-btn text-2xl">
                                        <i class="fab fa-instagram"></i>
                                    </a>

                                    <div>
                                        <h4 class="font-black text-lg">
                                            Instagram
                                        </h4>

                                        <p class="text-slate-400">
                                            @rk_institute_1
                                        </p>
                                    </div>

                                </div>

                                <!-- FACEBOOK -->
                                <div class="flex items-center gap-6">

                                    <a href="https://www.facebook.com/share/1CLCuBEQKz/"
                                       class="social-btn text-2xl">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>

                                    <div>
                                        <h4 class="font-black text-lg">
                                            Facebook
                                        </h4>

                                        <p class="text-slate-400">
                                            RK Institute
                                        </p>
                                    </div>

                                </div>

                                <!-- YOUTUBE -->
                                <!-- <div class="flex items-center gap-6">

                                    <a href="#"
                                       class="social-btn text-2xl">
                                        <i class="fab fa-youtube"></i>
                                    </a>

                                    <div>
                                        <h4 class="font-black text-lg">
                                            YouTube
                                        </h4>

                                        <p class="text-slate-400">
                                            RK Institute
                                        </p>
                                    </div>

                                </div> -->

                            </div>

                        </div>

                        <!-- SUPPORT CARD -->
                        <div class="relative z-10 mt-20 glass-card rounded-[2rem] p-8">

                            <div class="flex items-center mb-5">

                                <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>

                                <h4 class="font-black text-lg">
                                    Student Support Available
                                </h4>

                            </div>

                            <p class="text-slate-300 leading-relaxed">
                                Our admissions team is ready to assist you with
                                course details, fees, career guidance, and enrollment support.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>

@endsection