@extends('layouts.client')

@section('title', 'About Us - RK Institute of Commerce')

@section('styles')
<style>
    :root{
        --rk-primary:#0f2d62;
        --rk-secondary:#0f172a;
        --rk-accent:#d4a437;
        --rk-light:#f8fafc;
        --rk-border:#e2e8f0;
    }

    html{
        scroll-behavior:smooth;
    }

    body{
        font-family:'Inter',sans-serif;
        background:#fff;
        color:#0f172a;
    }

    .hero-section{
        background:
            linear-gradient(rgba(2,6,23,.88),rgba(15,23,42,.92)),
            url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1600&q=80');
        background-size:cover;
        background-position:center;
    }

    .section-tag{
        letter-spacing:.18em;
    }

    .section-heading{
        position:relative;
        display:inline-block;
        padding-bottom:16px;
    }

    .section-heading::after{
        content:'';
        position:absolute;
        left:0;
        bottom:0;
        width:70px;
        height:5px;
        border-radius:999px;
        background:var(--rk-accent);
    }

    .rk-card{
        border:1px solid var(--rk-border);
        transition:.35s ease;
    }

    .rk-card:hover{
        transform:translateY(-8px);
        box-shadow:0 25px 60px rgba(15,23,42,.08);
    }

    .icon-box{
        width:70px;
        height:70px;
        border-radius:24px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:28px;
    }

    .course-card{
        transition:.3s ease;
        border:1px solid #e2e8f0;
        color: var(--rk-primary);
    }

    .course-card:hover{
        background:#0f172a;
        color: var(--rk-primary);
        transform:translateY(-8px);
        
    }

    .course-card:hover p{
        color:#cbd5e1;
    }

    .course-card:hover h4{
        color:#fff;
    }

    .stats-card{
        background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);
    }

    .vision-list li{
        position:relative;
        padding-left:34px;
    }

    .vision-list li::before{
        content:'✓';
        position:absolute;
        left:0;
        top:0;
        color:#d4a437;
        font-weight:900;
    }

    .cta-section{
        background:
            linear-gradient(rgba(15,23,42,.92),rgba(15,23,42,.92)),
            url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80');
        background-size:cover;
        background-position:center;
    }
</style>
@endsection

@section('content')

<main class="overflow-hidden">

    <!-- HERO -->
    <section class="hero-section py-32 flex justify-center items-center">
    <div class="container mx-auto px-6 text-center">

        <!-- mx-auto on the wrapper div keeps the content width constrained but centered -->
        <div class="max-w-4xl mx-auto">

            <p class="section-tag text-sm uppercase font-black text-amber-400 mb-5">
                About RK Institute of Commerce
            </p>

            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                Empowering Minds.<br>
                <span class="text-amber-400">Building Futures.</span>
            </h1>

            <!-- mx-auto here ensures the paragraph text stays centered within its max-width -->
            <p class="text-xl text-slate-300 leading-relaxed max-w-4xl mx-auto">
                RK Institute of Commerce is committed to delivering practical,
                affordable, and career-oriented education in Commerce,
                Management, Taxation, and Computerized Accounting.
            </p>

        </div>

    </div>
</section>

    <!-- ABOUT -->
    <section class="py-28 bg-white">
        <div class="container mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-20 items-center">

                <div>

                    <p class="section-tag text-sm uppercase font-black text-amber-500 mb-4">
                        About Institute
                    </p>

                    <h2 class="section-heading text-4xl md:text-5xl font-black text-slate-900 mb-10">
                        Established With Strong Educational Values
                    </h2>

                    <div class="space-y-6 text-lg text-slate-600 leading-relaxed">

                        <p>
                            RK Institute of Commerce was established in 2013 with
                            the vision of creating strong character, practical
                            knowledge, and career-focused education for students.
                        </p>

                        <p>
                            The institute is registered under Company Act 2013
                            on 26th April 2023 as
                            <strong>Ramesh Kolhe’s Learning Hub Pvt. Ltd.</strong>
                        </p>

                        <p>
                            We have a tradition of excellence in academics,
                            practical training, and professional development
                            with specialized focus on Commerce, Management,
                            Taxation, GST, and Computerized Accounting.
                        </p>

                    </div>

                </div>

                <div class="grid gap-6">

                    <div class="rk-card rounded-[2rem] p-8 bg-slate-50">
                        <div class="flex gap-5">

                            <div class="icon-box bg-indigo-100 text-indigo-700">
                                <i class="fa fa-graduation-cap"></i>
                            </div>

                            <div>
                                <h4 class="text-2xl font-black text-slate-900 mb-3">
                                    Quality Education
                                </h4>

                                <p class="text-slate-600 leading-relaxed">
                                    ISO 9001:2015 certified educational standards
                                    focused on student excellence and growth.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="rk-card rounded-[2rem] p-8 bg-slate-50">
                        <div class="flex gap-5">

                            <div class="icon-box bg-amber-100 text-amber-600">
                                <i class="fa fa-laptop"></i>
                            </div>

                            <div>
                                <h4 class="text-2xl font-black text-slate-900 mb-3">
                                    Practical Knowledge
                                </h4>

                                <p class="text-slate-600 leading-relaxed">
                                    Hands-on learning in accounting software,
                                    GST systems, taxation workflows, and finance tools.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="rk-card rounded-[2rem] p-8 bg-slate-50">
                        <div class="flex gap-5">

                            <div class="icon-box bg-green-100 text-green-600">
                                <i class="fa fa-briefcase"></i>
                            </div>

                            <div>
                                <h4 class="text-2xl font-black text-slate-900 mb-3">
                                    Career Focused
                                </h4>

                                <p class="text-slate-600 leading-relaxed">
                                    Career-oriented training programs designed
                                    to prepare students for real industry demands.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- STATS -->
    <section class="py-24 bg-slate-950">
        <div class="container mx-auto px-6">

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

                <div class="stats-card rounded-[2rem] p-10 text-center">
                    <h3 class="text-5xl font-black text-amber-400 mb-3">10+</h3>
                    <p class="text-slate-300 uppercase tracking-[0.2em] text-sm font-bold">
                        Years Experience
                    </p>
                </div>

                <div class="stats-card rounded-[2rem] p-10 text-center">
                    <h3 class="text-5xl font-black text-white mb-3">5000+</h3>
                    <p class="text-slate-300 uppercase tracking-[0.2em] text-sm font-bold">
                        Students Trained
                    </p>
                </div>

                <div class="stats-card rounded-[2rem] p-10 text-center">
                    <h3 class="text-5xl font-black text-blue-400 mb-3">100%</h3>
                    <p class="text-slate-300 uppercase tracking-[0.2em] text-sm font-bold">
                        Practical Exposure
                    </p>
                </div>

                <div class="stats-card rounded-[2rem] p-10 text-center">
                    <h3 class="text-5xl font-black text-green-400 mb-3">ISO</h3>
                    <p class="text-slate-300 uppercase tracking-[0.2em] text-sm font-bold">
                        Certified Institute
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- COURSES -->
    <section class="py-28 bg-slate-50">
        <div class="container mx-auto px-6">

            <div class="text-center max-w-3xl mx-auto mb-20">

                <p class="section-tag text-sm uppercase font-black text-amber-500 mb-4">
                    Our Courses
                </p>

                <h2 class="text-5xl font-black text-slate-900 mb-6">
                    Online & Offline Programs
                </h2>

                <p class="text-lg text-slate-500 leading-relaxed">
                    Industry-oriented training designed to develop technical,
                    analytical, and professional commerce skills.
                </p>

            </div>

            @php
                $courses = [
                    ['title'=>'Accounting','icon'=>'fa-calculator'],
                    ['title'=>'Costing','icon'=>'fa-wallet'],
                    ['title'=>'Income Tax','icon'=>'fa-percent'],
                    ['title'=>'GST','icon'=>'fa-file-invoice'],
                    ['title'=>'Computerized Accounting','icon'=>'fa-desktop'],
                ];
            @endphp

            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6">

                @foreach($courses as $course)
                <div class="course-card bg-white rounded-[2rem] p-10 text-center">

                    <div class="w-20 h-20 mx-auto rounded-3xl bg-slate-100 flex items-center justify-center text-3xl mb-8 group-hover:color-blue">
                        <i class="fa {{ $course['icon'] }}"></i>
                    </div>

                    <h4 class="text-xl font-black mb-3">
                        {{ $course['title'] }}
                    </h4>

                    <p class="text-slate-500 text-sm leading-relaxed">
                        Professional practical training with modern tools and concepts.
                    </p>

                </div>
                @endforeach

            </div>

        </div>
    </section>

    <!-- MISSION & VISION -->
    <section class="py-28 bg-white">
        <div class="container mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-16">

                <!-- Mission -->
                <div class="rk-card rounded-[2.5rem] p-12 bg-slate-50">

                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-3xl">
                            <i class="fa fa-bullseye"></i>
                        </div>

                        <h2 class="text-4xl font-black text-slate-900">
                            Our Mission
                        </h2>
                    </div>

                    <p class="text-lg text-slate-600 leading-relaxed mb-8">
                        Our mission is to provide students with high-quality,
                        affordable education that builds confidence, practical
                        skills, ethical values, and career opportunities.
                    </p>

                    <p class="text-lg text-slate-600 leading-relaxed">
                        We aim to develop knowledgeable professionals and
                        open-minded future leaders who think globally and
                        contribute positively to society.
                    </p>

                </div>

                <!-- Vision -->
                <div class="rk-card rounded-[2.5rem] p-12 bg-slate-50">

                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-3xl">
                            <i class="fa fa-eye"></i>
                        </div>

                        <h2 class="text-4xl font-black text-slate-900">
                            Our Vision
                        </h2>
                    </div>

                    <ul class="vision-list space-y-5 text-lg text-slate-600 leading-relaxed">
                        <li>To provide affordable quality education.</li>

                        <li>
                            To teach important life values like honesty,
                            discipline, and humanity.
                        </li>

                        <li>
                            To help students realize their full potential
                            and become future leaders and entrepreneurs.
                        </li>

                        <li>
                            To develop positive thinking and confidence in students.
                        </li>

                        <li>
                            To create strong career paths through practical learning.
                        </li>
                    </ul>

                </div>

            </div>

        </div>
    </section>

    <!-- DIRECTOR MESSAGE -->
    <section class="py-28 bg-slate-950">
        <div class="container mx-auto px-6">

            <div class="max-w-4xl mx-auto text-center">

                <p class="section-tag text-sm uppercase font-black text-amber-400 mb-5">
                    Director Message
                </p>

                <h2 class="text-5xl font-black text-white mb-10">
                    Education That Creates Opportunities
                </h2>

                <blockquote class="text-slate-300 text-2xl leading-relaxed italic mb-12">
                    “Our goal is to empower students with practical knowledge,
                    professional skills, and strong values that help them build
                    successful careers and meaningful lives.”
                </blockquote>

                <div class="inline-flex items-center gap-5">

                    <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center text-white font-black text-xl">
                        RK
                    </div>

                    <div class="text-left">
                        <h4 class="text-2xl font-black text-white">
                            Mr. Ramesh Kolhe
                        </h4>

                        <p class="text-amber-400 uppercase tracking-[0.2em] text-xs font-bold">
                            Director
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section py-28 text-center">
        <div class="container mx-auto px-6">

            <h2 class="text-5xl md:text-6xl font-black text-white leading-tight mb-8">
                Start Your Professional Journey Today
            </h2>

            <p class="text-slate-300 text-xl max-w-3xl mx-auto leading-relaxed mb-12">
                Join RK Institute of Commerce and gain practical skills,
                confidence, and industry knowledge for long-term success.
            </p>

            <div class="flex flex-wrap justify-center gap-6">

                <a href="{{ route('student.register') }}"
                   class="px-10 py-5 bg-amber-500 hover:bg-amber-400 text-slate-900 font-black rounded-2xl transition">
                    Enroll Now
                </a>

                <a href="{{ route('contact') }}"
                   class="px-10 py-5 border border-white/20 hover:bg-white/10 text-white font-black rounded-2xl transition">
                    Contact Us
                </a>

            </div>

        </div>
    </section>

</main>

@endsection