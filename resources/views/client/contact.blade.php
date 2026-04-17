@extends('layouts.client')

@section('title', 'Contact Academic Support - RK Learning Hub')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .lms-contact {
        font-family: 'Outfit', sans-serif;
        background-color: #f8fafc;
        color: #1e293b;
    }

    .contact-hero {
        background: #0f172a;
        padding: 80px 0 160px;
        color: white;
        text-align: center;
    }

    .form-card {
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .info-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        border-color: #2563eb;
        background: #ffffff;
        transform: translateY(-2px);
    }

    .form-input {
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        border-color: #2563eb;
        outline: none;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.05);
    }

    .contact-btn {
        background: #2563eb;
        color: white;
        padding: 18px 32px;
        border-radius: 16px;
        font-weight: 800;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.2s ease;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
    }

    .contact-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 20px;
    }
</style>

<div class="lms-contact min-h-screen">
    <!-- Hero Header -->
    <section class="contact-hero">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight">Academic Support Center</h1>
            <p class="text-slate-400 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed">Have questions about our curriculum or your enrollment? Our technical and academic teams are here to assist you.</p>
        </div>
    </section>

    <!-- Content Matrix -->
    <section class="container mx-auto px-6 -mt-24 pb-32">
        <div class="max-w-6xl mx-auto">
            <div class="form-card flex flex-col lg:flex-row shadow-2xl">
                
                <!-- Contact Methods -->
                <div class="lg:w-1/3 bg-slate-900 p-12 lg:p-16 text-white">
                    <h3 class="text-2xl font-black mb-8 uppercase tracking-tight">Contact Hub</h3>
                    <p class="text-slate-400 text-sm font-medium mb-12 leading-relaxed italic">Our counselors are available Monday — Friday, 09:00 to 18:00 IST.</p>
                    
                    <div class="space-y-10">
                        <div class="flex gap-5">
                            <i class="fa fa-phone text-blue-500 text-xl mt-1"></i>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Tele-Counseling</p>
                                <p class="text-lg font-bold">+1 (234) 567 890</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <i class="fa fa-envelope text-blue-500 text-xl mt-1"></i>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Official Inquiry</p>
                                <p class="text-lg font-bold">hello@rk-learning.com</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <i class="fa fa-location-dot text-blue-500 text-xl mt-1"></i>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Main Campus</p>
                                <p class="text-lg font-bold leading-snug">123 Knowledge St, NY 10001</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-20 pt-10 border-t border-slate-800">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-6 text-center">Follow the Hub</p>
                        <div class="flex justify-center gap-6">
                            <a href="#" class="text-slate-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-slate-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-slate-400 hover:text-white transition"><i class="fab fa-x-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:w-2/3 p-12 lg:p-20 bg-white">
                    <form action="#" method="POST" class="space-y-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Full Student Name</label>
                                <input type="text" class="form-input" placeholder="Alexander Thorne">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Academic Email</label>
                                <input type="email" class="form-input" placeholder="alex@learning.curriculum">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Department / Inquiry Category</label>
                            <select class="form-input appearance-none bg-white cursor-pointer">
                                <option>General Course Information</option>
                                <option>Enrollment Assistance</option>
                                <option>Technical Platform Issue</option>
                                <option>Institutional Partnership</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Brief Description</label>
                            <textarea rows="5" class="form-input" placeholder="Enter your inquiry details here..."></textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="contact-btn w-full md:w-auto">Transmit Dispatch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Simplified Office Info -->
    <section class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8 pb-32">
        <div class="info-card">
            <div class="icon-circle"><i class="fa fa-life-ring"></i></div>
            <h4 class="text-lg font-black text-slate-900 mb-2">24/7 Knowledge Base</h4>
            <p class="text-sm text-slate-500 font-medium leading-relaxed">Access our comprehensive FAQ and documentation anytime for instant answers.</p>
        </div>
        <div class="info-card">
            <div class="icon-circle"><i class="fa fa-users-gear"></i></div>
            <h4 class="text-lg font-black text-slate-900 mb-2">Technical Guidance</h4>
            <p class="text-sm text-slate-500 font-medium leading-relaxed">Stuck on a module? Our instructional team provides code and curriculum reviews.</p>
        </div>
        <div class="info-card">
            <div class="icon-circle"><i class="fa fa-building-columns"></i></div>
            <h4 class="text-lg font-black text-slate-900 mb-2">Campus Visitation</h4>
            <p class="text-sm text-slate-500 font-medium leading-relaxed">Visit our administrative center for direct career counseling and academic roadmap planning.</p>
        </div>
    </section>
</div>
@endsection
