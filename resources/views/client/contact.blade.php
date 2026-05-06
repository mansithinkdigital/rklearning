@extends('layouts.client')

@section('title', 'Academic Support - RK Institute')

@section('styles')
<style>
    @keyframes revealUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes grain {
        0%, 100% { transform: translate(0, 0); }
        10% { transform: translate(-5%, -10%); }
        30% { transform: translate(3%, -15%); }
        50% { transform: translate(12%, 9%); }
        70% { transform: translate(-9%, 4%); }
        90% { transform: translate(2%, -3%); }
    }

    .reveal {
        animation: revealUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
    }

    .grain-overlay::before {
        content: "";
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background-image: url("https://grainy-gradients.vercel.app/noise.svg");
        opacity: 0.05;
        pointer-events: none;
        animation: grain 8s steps(10) infinite;
        z-index: 1;
    }

    .contact-input {
        width: 100%;
        padding: 20px;
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 0px;
        font-weight: 600;
        transition: all 0.3s ease;
        border-bottom: 2px solid #0f172a;
    }

    .contact-input:focus {
        background: white;
        border-color: #4f46e5;
        outline: none;
        padding-left: 24px;
    }

    .neo-card {
        background: white;
        border: 2px solid #0f172a;
        box-shadow: 12px 12px 0px #0f172a;
        transition: all 0.3s ease;
    }

    .method-card {
        border-left: 4px solid #4f46e5;
        padding-left: 24px;
        transition: all 0.3s ease;
    }

    .method-card:hover {
        transform: translateX(8px);
    }
</style>
@endsection

@section('content')
<main class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class="relative bg-slate-900 pt-32 pb-48 grain-overlay">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl">
                <span class="inline-block px-4 py-1.5 bg-indigo-500/10 text-indigo-400 rounded-full text-xs font-black uppercase tracking-[0.2em] mb-8 reveal" style="animation-delay: 0.1s">
                    Direct Liaison
                </span>
                <h1 class="text-6xl md:text-8xl font-black text-white leading-[0.9] mb-12 reveal" style="animation-delay: 0.2s">
                    Connect with the <br> 
                    <span class="text-indigo-500">Academic</span> <br>
                    <span class="text-white opacity-20">Registrar.</span>
                </h1>
                <p class="text-slate-400 text-xl font-medium max-w-2xl leading-relaxed reveal" style="animation-delay: 0.3s">
                    Technical inquiries, institutional partnerships, or curriculum guidance. Our specialists provide direct, high-fidelity support for your academic journey.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Matrix -->
    <section class="py-24 bg-white relative -mt-32 z-20">
        <div class="container mx-auto px-6">
            <div class="neo-card flex flex-col lg:flex-row overflow-hidden reveal">
                <!-- Contact Info -->
                <div class="lg:w-1/3 bg-slate-900 p-12 lg:p-16 text-white flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-black mb-12 uppercase tracking-widest text-indigo-400">The Hub HQ</h3>
                        
                        <div class="space-y-12">
                            <div class="method-card">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-2">Voice Dispatch</p>
                                <p class="text-xl font-bold">+1 (234) 567 890</p>
                                <p class="text-xs text-slate-500 mt-1">Available 09:00 — 18:00 IST</p>
                            </div>
                            
                            <div class="method-card">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-2">Electronic Mail</p>
                                <p class="text-xl font-bold">hello@rk-learning.com</p>
                                <p class="text-xs text-slate-500 mt-1">Response within 12 academic hours</p>
                            </div>

                            <div class="method-card">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-2">Main Lab</p>
                                <p class="text-xl font-bold">123 Knowledge City, <br>NY 10001, USA</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 pt-12 border-t border-slate-800">
                        <div class="flex gap-8">
                            <a href="#" class="text-slate-400 hover:text-indigo-400 transition-colors"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-slate-400 hover:text-indigo-400 transition-colors"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-slate-400 hover:text-indigo-400 transition-colors"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:w-2/3 p-12 lg:p-24 bg-white">
                    <form action="#" method="POST" class="space-y-12">
                        <div class="grid md:grid-cols-2 gap-12">
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Formal Name</label>
                                <input type="text" class="contact-input" placeholder="e.g. Alexander Thorne">
                            </div>
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Academic Identity</label>
                                <input type="email" class="contact-input" placeholder="e.g. alex@university.edu">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Inquiry Classification</label>
                            <select class="contact-input cursor-pointer appearance-none bg-no-repeat bg-[right_20px_center]" style="background-image: url('data:image/svg+xml;charset=utf-8,<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'><path stroke=\'%230f172a\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M6 8l4 4 4-4\'/></svg>');">
                                <option>Curriculum Specialization Inquiry</option>
                                <option>Institutional Strategic Partnership</option>
                                <option>Technical Platform Architecture</option>
                                <option>Career Acceleration Guidance</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Detailed Brief</label>
                            <textarea rows="4" class="contact-input" placeholder="Explain your requirements in detail..."></textarea>
                        </div>

                        <div class="pt-8">
                            <button type="submit" class="px-12 py-6 bg-slate-900 text-white font-black uppercase tracking-widest text-sm hover:bg-indigo-600 transition-all rounded-full">
                                Transmit Dispatch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Secondary Info -->
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6 grid md:grid-cols-3 gap-12">
            <div class="reveal" style="animation-delay: 0.1s">
                <div class="w-12 h-12 bg-indigo-600 text-white flex items-center justify-center text-xl mb-6">
                    <i class="fa fa-life-ring"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900 mb-4 uppercase tracking-tight">24/7 Repository</h4>
                <p class="text-slate-500 font-medium leading-relaxed">Most procedural questions are addressed in our exhaustive Knowledge Base. Explore documentation before initiating dispatch.</p>
            </div>
            
            <div class="reveal" style="animation-delay: 0.2s">
                <div class="w-12 h-12 bg-indigo-600 text-white flex items-center justify-center text-xl mb-6">
                    <i class="fa fa-users-gear"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900 mb-4 uppercase tracking-tight">Curriculum Clinic</h4>
                <p class="text-slate-500 font-medium leading-relaxed">Stuck on a specific architectural module? Our instructional team hosts live code-review clinics every Tuesday and Thursday.</p>
            </div>

            <div class="reveal" style="animation-delay: 0.3s">
                <div class="w-12 h-12 bg-indigo-600 text-white flex items-center justify-center text-xl mb-6">
                    <i class="fa fa-building-columns"></i>
                </div>
                <h4 class="text-xl font-black text-slate-900 mb-4 uppercase tracking-tight">Campus Visit</h4>
                <p class="text-slate-500 font-medium leading-relaxed">Direct career counseling sessions are available at our physical lab. Appointments must be scheduled 72 hours in advance.</p>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reveals = document.querySelectorAll('.reveal');
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.classList.add('animate-revealUp');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        reveals.forEach(el => observer.observe(el));
    });
</script>
@endsection