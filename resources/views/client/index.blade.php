@extends('layouts.client')

@section('title', 'RK Institute — Modern Professional Education')

@section('styles')
<style>
    :root{
        --primary:#2563EB;
        --primary-dark:#1D4ED8;
        --secondary:#0F172A;
        --muted:#64748B;
        --border:#E2E8F0;
        --bg:#F8FAFC;
    }

    html{
        scroll-behavior:smooth;
    }

    body{
        background:#fff;
        color:var(--secondary);
        font-family:Inter,sans-serif;
    }

    .container-rk{
        max-width:1280px;
    }

    .section-padding{
        padding:110px 0;
    }

    .section-badge{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:10px 18px;
        border-radius:999px;
        background:rgba(37,99,235,.06);
        border:1px solid rgba(37,99,235,.08);
        color:var(--primary);
        font-size:12px;
        font-weight:700;
        letter-spacing:.12em;
        text-transform:uppercase;
    }

    .section-title{
        font-size:56px;
        line-height:1.05;
        font-weight:900;
        letter-spacing:-0.04em;
        color:var(--secondary);
    }

    .section-text{
        color:var(--muted);
        font-size:18px;
        line-height:1.9;
    }

    .hero-bg{
        background:
            radial-gradient(circle at top left, rgba(37,99,235,.08), transparent 35%),
            radial-gradient(circle at bottom right, rgba(59,130,246,.06), transparent 30%),
            #F8FAFC;
    }

    .gradient-text{
        background:linear-gradient(135deg,#2563EB 0%,#1D4ED8 100%);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
    }

    .btn-primary{
        background:var(--primary);
        color:#fff;
        border-radius:16px;
        padding:16px 30px;
        font-weight:700;
        transition:.3s ease;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:12px;
        box-shadow:0 10px 30px rgba(37,99,235,.18);
    }

    .btn-primary:hover{
        background:var(--primary-dark);
        transform:translateY(-2px);
    }

    .btn-secondary{
        background:#fff;
        border:1px solid var(--border);
        color:var(--secondary);
        border-radius:16px;
        padding:16px 30px;
        font-weight:700;
        transition:.3s ease;
    }

    .btn-secondary:hover{
        border-color:var(--primary);
        color:var(--primary);
    }

    .hero-image-wrapper{
        position:relative;
    }

    .hero-image{
        border-radius:36px;
        overflow:hidden;
        box-shadow:
            0 40px 100px rgba(15,23,42,.12),
            0 10px 20px rgba(15,23,42,.05);
    }

    .hero-image img{
        width:100%;
        height:700px;
        object-fit:cover;
    }

    .floating-card{
        position:absolute;
        background:rgba(255,255,255,.96);
        border:1px solid rgba(255,255,255,.4);
        backdrop-filter:blur(14px);
        border-radius:24px;
        padding:22px;
        box-shadow:0 20px 50px rgba(0,0,0,.08);
    }

    .hero-stat{
        background:#fff;
        border:1px solid var(--border);
        border-radius:24px;
        padding:30px;
    }

    .feature-card,
    .course-card,
    .testimonial-card,
    .why-card{
        background:#fff;
        border:1px solid var(--border);
        border-radius:28px;
        transition:.35s ease;
    }

    .feature-card:hover,
    .course-card:hover,
    .testimonial-card:hover,
    .why-card:hover{
        transform:translateY(-6px);
        box-shadow:0 30px 60px rgba(15,23,42,.08);
    }

    .icon-box{
        width:70px;
        height:70px;
        border-radius:22px;
        background:#EFF6FF;
        color:var(--primary);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:28px;
    }

    .course-card{
        overflow:hidden;
    }

    .course-image{
        overflow:hidden;
    }

    .course-image img{
        width:100%;
        height:240px;
        object-fit:cover;
        transition:.6s ease;
    }

    .course-card:hover .course-image img{
        transform:scale(1.05);
    }

    .glass-card{
        background:rgba(255,255,255,.7);
        backdrop-filter:blur(14px);
        border:1px solid rgba(255,255,255,.4);
    }

    .cta-box{
        background:
            radial-gradient(circle at top left, rgba(255,255,255,.08), transparent 30%),
            linear-gradient(135deg,#0F172A 0%,#1E293B 100%);
        border-radius:42px;
        overflow:hidden;
        position:relative;
    }

    .cta-box::before{
        content:'';
        position:absolute;
        width:400px;
        height:400px;
        background:rgba(37,99,235,.18);
        filter:blur(120px);
        top:-120px;
        right:-120px;
    }

    .grid-pattern{
        background-image:
            linear-gradient(rgba(148,163,184,.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148,163,184,.08) 1px, transparent 1px);
        background-size:40px 40px;
    }

    @media(max-width:1024px){

        .section-title{
            font-size:44px;
        }

        .hero-image img{
            height:500px;
        }
    }

    @media(max-width:640px){

        .section-title{
            font-size:36px;
        }

        .section-padding{
            padding:80px 0;
        }
    }
</style>
@endsection

@section('content')

<!-- HERO -->
<section class="hero-bg overflow-hidden">

    <div class="container-rk mx-auto px-6 pt-28 pb-24">

        <div class="grid lg:grid-cols-2 gap-20 items-center">

            <!-- LEFT -->
            <div>

                <span class="section-badge mb-8">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Modern Professional Learning
                </span>

                <h1 class="section-title mb-8">
                    Build a Career With
                    <span class="gradient-text">
                        Practical Skills
                    </span>
                    That Actually Matter.
                </h1>

                <p class="section-text max-w-2xl mb-10">
                    RK Institute helps students gain industry-focused knowledge through
                    structured courses, mentorship, and hands-on learning experiences
                    designed for real career growth.
                </p>

                <div class="flex flex-wrap gap-4 mb-14">

                    @auth
                        <a href="{{ route('student.dashboard') }}" class="btn-primary">
                            Go To Dashboard
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('student.register') }}" class="btn-primary">
                            Start Learning
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    @endauth

                    <a href="{{ route('courses') }}" class="btn-secondary">
                        Browse Courses
                    </a>

                </div>

                <!-- TRUST -->
                <div class="grid grid-cols-3 gap-5">

                    <div class="hero-stat">
                        <h3 class="text-4xl font-black">
                            {{ $totalStudents }}+
                        </h3>

                        <p class="text-slate-500 mt-2 text-sm">
                            Active Students
                        </p>
                    </div>

                    <div class="hero-stat">
                        <h3 class="text-4xl font-black">
                            {{ $totalCourses }}+
                        </h3>

                        <p class="text-slate-500 mt-2 text-sm">
                            Courses
                        </p>
                    </div>

                    <div class="hero-stat">
                        <h3 class="text-4xl font-black">
                            {{ $totalLessons }}+
                        </h3>

                        <p class="text-slate-500 mt-2 text-sm">
                            Lessons
                        </p>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="hero-image-wrapper">

                <div class="hero-image">

                    <img
                        src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop"
                        alt="RK Institute">

                </div>

                <!-- FLOATING CARD -->
                <div class="floating-card hidden lg:block -bottom-10 -left-10">

                    <div class="flex items-center gap-5">

                        <div class="icon-box">
                            <i class="fa fa-graduation-cap"></i>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-2">
                                Student Success
                            </p>

                            <h4 class="text-3xl font-black">
                                95%
                            </h4>

                            <p class="text-sm text-slate-500 mt-1">
                                Course completion rate
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- FEATURES -->
<section class="section-padding bg-white">

    <div class="container-rk mx-auto px-6">

        <div class="grid md:grid-cols-3 gap-8">

            <div class="feature-card p-10">

                <div class="icon-box mb-8">
                    <i class="fa fa-laptop-code"></i>
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Industry Focused Courses
                </h3>

                <p class="text-slate-600 leading-relaxed">
                    Learn practical concepts designed around real-world industry needs and modern technologies.
                </p>

            </div>

            <div class="feature-card p-10">

                <div class="icon-box mb-8">
                    <i class="fa fa-user-tie"></i>
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Expert Mentorship
                </h3>

                <p class="text-slate-600 leading-relaxed">
                    Get guidance from experienced mentors and professionals throughout your learning journey.
                </p>

            </div>

            <div class="feature-card p-10">

                <div class="icon-box mb-8">
                    <i class="fa fa-certificate"></i>
                </div>

                <h3 class="text-2xl font-bold mb-5">
                    Career Growth
                </h3>

                <p class="text-slate-600 leading-relaxed">
                    Build valuable skills, strengthen your portfolio, and improve professional opportunities.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- ABOUT -->
<section class="section-padding bg-slate-50 grid-pattern">

    <div class="container-rk mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-24 items-center">

            <!-- IMAGES -->
            <div class="relative">

                <div class="grid grid-cols-2 gap-6">

                    <img
                        src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop"
                        class="rounded-[32px] h-[520px] object-cover w-full mt-12 shadow-xl">

                    <img
                        src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop"
                        class="rounded-[32px] h-[520px] object-cover w-full shadow-xl">

                </div>

            </div>

            <!-- CONTENT -->
            <div>

                <span class="section-badge mb-8">
                    About RK Institute
                </span>

                <h2 class="section-title mb-8">
                    Designed For Serious Learning & Career Growth
                </h2>

                <p class="section-text mb-12">
                    We believe education should be practical, modern, and accessible.
                    RK Institute focuses on helping students gain confidence through
                    real projects, mentorship, and structured learning experiences.
                </p>

                <div class="space-y-6">

                    <div class="why-card p-7">

                        <div class="flex gap-5">

                            <div class="icon-box shrink-0">
                                <i class="fa fa-check"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-xl mb-3">
                                    Practical Learning Approach
                                </h4>

                                <p class="text-slate-500 leading-relaxed">
                                    Courses include projects and assignments focused on real-world implementation.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="why-card p-7">

                        <div class="flex gap-5">

                            <div class="icon-box shrink-0">
                                <i class="fa fa-check"></i>
                            </div>

                            <div>
                                <h4 class="font-bold text-xl mb-3">
                                    Flexible Online Access
                                </h4>

                                <p class="text-slate-500 leading-relaxed">
                                    Learn anytime and continue your education at your own pace.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- COURSES -->
<section class="section-padding bg-[#F8FAFC] overflow-hidden">
    <div class="container-rk mx-auto px-6">

        <!-- HEADER: More Balanced & Modern -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-12 mb-16">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-12 h-[2px] bg-blue-600"></span>
                    <span class="text-blue-600 font-bold uppercase tracking-widest text-xs">Featured Programs</span>
                </div>

                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 leading-[1.1] mb-6">
                    Learn Skills That Create 
                    <span class="relative inline-block">
                        <span class="relative z-10 text-blue-600">Real Opportunities</span>
                        <span class="absolute bottom-2 left-0 w-full h-3 bg-blue-100 -z-10"></span>
                    </span>
                </h2>

                <p class="text-lg text-slate-500 leading-relaxed">
                    Industry-validated courses designed to take you from beginner to job-ready. 
                    No fluff—just practical, hands-on learning.
                </p>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden sm:block">
                    <p class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-1">Live Catalog</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalCourses }} Available</p>
                </div>
                <a href="{{ route('courses') }}" 
                   class="group inline-flex items-center gap-3 bg-white border-2 border-slate-900 hover:bg-slate-900 hover:text-white transition-all duration-300 text-slate-900 px-8 py-4 rounded-2xl font-bold shadow-sm">
                    View All
                    <i class="fa fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>

        <!-- GRID: Refined Card Design -->
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-10">
            @foreach($courses as $course)
            <div class="group bg-white rounded-[32px] border border-slate-200/60 p-4 transition-all duration-500 hover:shadow-[0_40px_100px_-20px_rgba(15,23,42,0.1)] hover:border-blue-200">
                
                <!-- IMAGE CONTAINER -->
                <div class="relative aspect-[16/10] rounded-[24px] overflow-hidden mb-6">
                    <img 
                        src="{{ asset('admin/uploads/courseimg/'.$course->image) }}" 
                        alt="{{ $course->name }}"
                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <!-- Floating Badges -->
                    <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                        <span class="bg-white/95 backdrop-blur shadow-sm text-slate-900 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-lg">
                            {{ $course->category->name ?? 'Professional' }}
                        </span>
                        
                        <div class="flex items-center gap-1.5 bg-slate-900/80 backdrop-blur text-white px-3 py-1.5 rounded-lg text-xs font-bold">
                            <i class="fa fa-star text-yellow-400 text-[10px]"></i>
                            4.9
                        </div>
                    </div>

                    <!-- Student Count Glass Tag -->
                    <div class="absolute bottom-4 left-4 bg-white/20 backdrop-blur-md border border-white/30 text-white px-4 py-2 rounded-xl">
                        <p class="text-[10px] uppercase font-bold tracking-tighter opacity-80 leading-none mb-1">Enrolled</p>
                        <p class="text-sm font-black leading-none">{{ number_format($course->students_count ?? $course->students->count()) }}+</p>
                    </div>
                </div>

                <!-- INFO BODY -->
                <div class="px-3 pb-4">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center gap-1.5 text-blue-600 font-bold text-xs uppercase tracking-wide">
                            <i class="fa fa-circle-play"></i>
                            {{ $course->subjects_count ?? $course->subjects->count() }} Modules
                        </div>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <div class="text-slate-400 font-medium text-xs uppercase tracking-wide">
                            Lifetime Access
                        </div>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 leading-tight mb-4 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2 min-h-[4rem]">
                        {{ $course->name }}
                    </h3>

                    <!-- Divider -->
                    <div class="h-px w-full bg-slate-100 mb-6"></div>

                    <!-- FOOTER: Pricing & CTA -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Investment</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-black text-slate-900">
                                    {{ $course->price > 0 ? '₹' . number_format($course->price, 0) : 'Free' }}
                                </span>
                                @if($course->price > 0)
                                    <span class="text-xs font-bold text-slate-400">INR</span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('courses.show',$course->id) }}" 
                           class="flex items-center justify-center w-12 h-12 rounded-xl bg-slate-50 text-slate-900 border border-slate-200 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300 shadow-sm">
                            <i class="fa fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- MOBILE CTA -->
        <div class="mt-16 text-center lg:hidden">
            <a href="{{ route('courses') }}"
               class="inline-flex items-center gap-3 bg-slate-900 text-white px-10 py-5 rounded-2xl font-bold shadow-xl shadow-slate-900/20">
                Explore All Courses
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>



<!-- TESTIMONIALS -->
<section class="section-padding bg-slate-50">

    <div class="container-rk mx-auto px-6">

        <div class="text-center mb-20">

            <span class="section-badge mb-7">
                Student Feedback
            </span>

            <h2 class="section-title">
                What Students Say About RK Institute
            </h2>

        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            @php
                $testimonials = [
                    [
                        'name' => 'Rahul Sharma',
                        'role' => 'Frontend Developer',
                        'text' => 'RK Institute provided a structured and professional learning experience that helped me improve my development skills significantly.'
                    ],
                    [
                        'name' => 'Priya Verma',
                        'role' => 'UI/UX Designer',
                        'text' => 'The mentorship and practical projects made learning much easier and more career-focused.'
                    ],
                    [
                        'name' => 'Amit Joshi',
                        'role' => 'Software Engineer',
                        'text' => 'Excellent platform with quality guidance, modern content, and practical assignments.'
                    ]
                ];
            @endphp

            @foreach($testimonials as $t)

            <div class="testimonial-card p-10">

                <div class="flex gap-1 text-yellow-400 mb-8">

                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>

                </div>

                <p class="text-slate-600 leading-relaxed text-lg mb-10">
                    "{{ $t['text'] }}"
                </p>

                <div>

                    <h4 class="font-bold text-xl">
                        {{ $t['name'] }}
                    </h4>

                    <p class="text-slate-500 mt-1">
                        {{ $t['role'] }}
                    </p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

<!-- CTA -->
<section class="section-padding bg-white">

    <div class="container-rk mx-auto px-6">

        <div class="cta-box p-14 lg:p-24 text-center text-white">

            <h2 class="text-5xl font-black leading-tight mb-8 relative z-10">
                Start Building Your Future Today
            </h2>

            <p class="text-slate-300 text-lg max-w-2xl mx-auto mb-12 relative z-10 leading-relaxed">
                Join RK Institute and gain practical skills designed for real-world success and long-term career growth.
            </p>

            <div class="flex justify-center gap-5 flex-wrap relative z-10">

                @guest
                    <a href="{{ route('student.register') }}" class="btn-primary">
                        Create Free Account
                    </a>
                @endguest

                <a href="{{ route('courses') }}" class="btn-secondary bg-white">
                    Explore Courses
                </a>

            </div>

        </div>

    </div>

</section>

@endsection