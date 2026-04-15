@extends('layouts.client')

@section('title', 'Learn New Things Daily - Rk Learning Hub')

@section('styles')
    <style>
        :root {
            --zilom-blue: #4F46E5;
            --zilom-blue-dark: #3730A3;
            --zilom-secondary: #0F172A;
            --zilom-bg-light: #F8FAFC;
        }

        .hero-section {
            background-color: #F8FAFC;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(251, 191, 36, 0.08) 0px, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234f46e5' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            position: relative;
            overflow: hidden;
            min-height: 850px;
            display: flex;
            align-items: center;
        }

        .hero-bg-accent {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            filter: blur(80px);
            animation: move-accent 25s infinite alternate;
        }

        @keyframes move-accent {
            0% { transform: translate(-20%, -20%) scale(1); }
            100% { transform: translate(20%, 20%) scale(1.2); }
        }

        .text-underline-premium {
            position: relative;
            display: inline-block;
        }

        .text-underline-premium::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 8px;
            width: 100%;
            height: 15px;
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.2) 0%, transparent 100%);
            z-index: -1;
            border-radius: 4px;
            transform: skewX(-15deg);
        }

        .stat-badge-premium {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 16px 28px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 16px;
            position: absolute;
            z-index: 30;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-badge-premium:hover {
            transform: translateY(-8px) scale(1.05) !important;
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.15);
        }

        .hero-floating-element {
            position: absolute;
            z-index: 10;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.1));
        }

        @keyframes float-premium {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(5deg); }
            66% { transform: translateY(-15px) rotate(-5deg); }
        }

        .animate-float-1 { animation: float-premium 8s ease-in-out infinite; }
        .animate-float-2 { animation: float-premium 10s ease-in-out infinite 1s; }
        .animate-float-3 { animation: float-premium 12s ease-in-out infinite 0.5s; }

        .image-glass-container {
            position: relative;
            padding: 15px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            border-radius: 70px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.15);
        }

        .image-glass-container::before {
            content: '';
            position: absolute;
            inset: -20px;
            background: linear-gradient(225deg, #4F46E5 0%, #A855F7 100%);
            border-radius: 80px;
            z-index: -1;
            opacity: 0.15;
            filter: blur(30px);
        }

        .btn-glow {
            position: relative;
            transition: all 0.3s ease;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            inset: 0;
            background: inherit;
            border-radius: inherit;
            z-index: -1;
            transition: all 0.3s ease;
            filter: blur(0px);
        }

        .btn-glow:hover::before {
            inset: -5px;
            filter: blur(15px);
            opacity: 0.6;
        }

        .text-gradient-premium {
            background: linear-gradient(135deg, #0F172A 0%, #4F46E5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-left { animation: slideInLeft 1s ease-out forwards; }
        .animate-slide-right { animation: slideInRight 1s ease-out forwards; }
        .animate-fade-up { animation: fadeInUp 1s ease-out forwards; }

        /* Other sections */
        .course-card { transition: all 0.3s ease; border: 1px solid #E2E8F0; }
        .course-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .newsletter-section { background-color: #4F46E5; border-top-left-radius: 100px; border-bottom-right-radius: 100px; }

    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section pt-16 pb-24 lg:pt-0 lg:pb-0 overflow-visible">
        <!-- Background Accents -->
        <div class="hero-bg-accent" style="top: -10%; right: -5%;"></div>
        <div class="hero-bg-accent" style="bottom: -10%; left: -5%;"></div>
        
        <!-- Animated Shapes -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-yellow-400/20 rounded-full blur-2xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16 lg:min-h-[850px]">
                
                <!-- Content Left -->
                <div class="lg:w-1/2 mt-12 lg:mt-0">
                    <div class="inline-flex items-center space-x-3 bg-indigo-50 border border-indigo-100/50 px-5 py-2.5 rounded-full mb-10 opacity-0 animate-fade-up"
                        style="animation-delay: 0.1s">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                        </span>
                        <span class="text-indigo-600 font-bold text-xs tracking-[0.2em] uppercase">The Future of Education</span>
                    </div>

                    <h1 class="text-6xl lg:text-[100px] font-black text-slate-900 mb-10 leading-[0.95] tracking-tight opacity-0 animate-fade-up" style="animation-delay: 0.2s">
                        Master your <br> <span class="text-gradient-premium">craft</span> <span class="text-underline-premium text-indigo-600">daily.</span>
                    </h1>

                    <p class="text-slate-500 text-xl lg:text-2xl mb-12 max-w-xl leading-relaxed opacity-0 animate-fade-up font-medium"
                        style="animation-delay: 0.3s">
                        Empower your journey with industry-leading courses. Join 50k+ students worldwide mastering new skills every day.
                    </p>

                    <div class="flex flex-wrap gap-6 opacity-0 animate-fade-up items-center" style="animation-delay: 0.4s">
                        <a href="{{ route('student.register') }}"
                            class="btn-glow group relative bg-indigo-600 text-white px-10 py-5 rounded-2xl font-bold text-lg shadow-2xl shadow-indigo-200 hover:-translate-y-1">
                            <span class="flex items-center">
                                Start Your Journey
                                <svg class="w-5 h-5 ml-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                        <a href="{{ route('courses') }}"
                            class="group bg-white text-slate-900 px-10 py-5 rounded-2xl font-bold text-lg border border-slate-200 hover:bg-slate-50 hover:border-indigo-200 transition-all">
                            Browse Courses
                        </a>
                    </div>

                    <div class="mt-20 flex items-center space-x-8 opacity-0 animate-fade-up" style="animation-delay: 0.5s">
                        <div class="flex -space-x-4">
                            @for($i = 20; $i < 24; $i++)
                            <div class="relative group cursor-pointer">
                                <img src="https://i.pravatar.cc/150?u={{$i}}"
                                    class="w-14 h-14 rounded-full border-4 border-white shadow-xl group-hover:scale-110 group-hover:z-10 transition-transform">
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-4 border-white rounded-full"></div>
                            </div>
                            @endfor
                            <div class="w-14 h-14 rounded-full bg-indigo-600 border-4 border-white shadow-xl flex items-center justify-center font-black text-white text-[10px]">
                                +50K
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center space-x-1 mb-1">
                                @for($i = 0; $i < 5; $i++)
                                <i class="fa fa-star text-yellow-400 text-sm"></i>
                                @endfor
                                <span class="text-slate-900 font-bold ml-2">4.9/5.0</span>
                            </div>
                            <p class="text-sm text-slate-500 font-medium">Trusted by 25,000+ teams worldwide</p>
                        </div>
                    </div>
                </div>

                <!-- Content Right (Visuals) -->
                <div class="lg:w-1/2 relative opacity-0 animate-fade-up" style="animation-delay: 0.3s">
                    
                    <!-- Premium Stat Badges -->
                    <div class="stat-badge-premium animate-float-1" style="top: 10%; right: -5%;">
                        <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner">
                            <i class="fa fa-graduation-cap text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Expert Mentors</p>
                            <p class="font-black text-slate-900 text-2xl leading-none font-outfit">850+</p>
                        </div>
                    </div>

                    <div class="stat-badge-premium animate-float-2" style="bottom: 15%; left: -10%;">
                        <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 shadow-inner">
                            <i class="fa fa-clock text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Course Hours</p>
                            <p class="font-black text-slate-900 text-2xl leading-none font-outfit">12,400+</p>
                        </div>
                    </div>

                    <!-- Floating Icons -->
                    <div class="hero-floating-element animate-float-3 flex items-center justify-center w-20 h-20 bg-white rounded-3xl" style="top: 50%; left: -20px;">
                        <i class="fa fa-code text-3xl text-indigo-600"></i>
                    </div>
                    
                    <div class="hero-floating-element animate-float-1 flex items-center justify-center w-16 h-16 bg-yellow-400 rounded-2xl shadow-yellow-200" style="bottom: 40%; right: -30px;">
                        <i class="fa fa-bolt text-2xl text-slate-900"></i>
                    </div>

                    <!-- Main Image Container -->
                    <div class="image-glass-container group">
                        <div class="relative rounded-[60px] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" 
                                alt="Modern Learning" 
                                class="w-full h-auto rounded-[56px] transition-all duration-1000 group-hover:scale-110">
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                            
                            <!-- Video Play Button (Fake) -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform cursor-pointer">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-2xl">
                                        <i class="fa fa-play text-indigo-600 ml-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Features section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex items-center space-x-4 p-6 bg-white rounded-xl shadow-sm border border-slate-50">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-zilom-blue text-2xl">
                        <i class="fa fa-book-open"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xl">Online Courses</h4>
                        <p class="text-sm text-slate-500">Learn anything, anywhere.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 p-6 bg-white rounded-xl shadow-sm border border-slate-50">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-zilom-blue text-2xl">
                        <i class="fa fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xl">Expert Instructions</h4>
                        <p class="text-sm text-slate-500">Learn from the best in world.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 p-6 bg-white rounded-xl shadow-sm border border-slate-50">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-zilom-blue text-2xl">
                        <i class="fa fa-lock-open"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xl">Certificates</h4>
                        <p class="text-sm text-slate-500">value all over the world</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 flex gap-4">
                    <div class="w-1/2 pt-12">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop"
                            class="rounded-2xl shadow-xl w-full h-[350px] object-cover" alt="Student Group">
                    </div>
                    <div class="w-1/2">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop"
                            class="rounded-2xl shadow-xl w-full h-[350px] object-cover" alt="Learning Center">
                        <div class="mt-4 bg-white p-6 rounded-2xl shadow-lg inline-block border-l-4 border-zilom-blue">
                            <p class="font-bold text-zilom-blue text-2xl">100%</p>
                            <p class="text-xs text-slate-500">Trusted Learning Center</p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <span class="text-zilom-blue font-semibold uppercase tracking-widest text-sm">Online Learning</span>
                    <h2 class="text-4xl font-bold text-slate-900 mt-4 mb-6 leading-tight">Welcome To The Online <br>
                        Learning Center</h2>
                    <p class="text-slate-600 mb-8 leading-relaxed">
                        There are many variations of passages of available but the majority have suffered alteration in some
                        form, by injected humour, or randomised words which don't look even slightly believable.
                    </p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center space-x-3">
                            <i class="fa fa-check-circle text-zilom-blue"></i>
                            <span class="text-slate-700">Explore a variety of fresh educational topics</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa fa-check-circle text-zilom-blue"></i>
                            <span class="text-slate-700">Find the right instructor for you</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa fa-check-circle text-zilom-blue"></i>
                            <span class="text-slate-700">Learn on your schedule everywhere</span>
                        </li>
                    </ul>
                    <a href="#"
                        class="bg-zilom-blue text-white px-8 py-3 rounded-md font-bold hover:bg-zilom-blue-dark transition-all">
                        Read More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-16">
                <span class="text-zilom-blue font-semibold uppercase tracking-widest text-sm">
                    Choose Your Course
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-4">
                    Explore Our Courses
                </h2>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto">
                    Learn practical skills with real content. Start free and upgrade anytime.
                </p>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $courses = [
                        ['id' => 1, 'title' => 'The Complete Web Developer Course', 'category' => 'Web Dev', 'price' => '$45.00', 'students' => '2.5k', 'lectures' => 12, 'resources' => 5, 'img' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=2072&auto=format&fit=crop'],
                        ['id' => 2, 'title' => 'UI/UX Design Masterclass 2024', 'category' => 'Design', 'price' => '$39.00', 'students' => '1.8k', 'lectures' => 8, 'resources' => 3, 'img' => 'https://images.unsplash.com/photo-1586717791821-3f44a563cc4c?q=80&w=2070&auto=format&fit=crop'],
                        ['id' => 3, 'title' => 'Marketing Advanced Bootcamp', 'category' => 'Marketing', 'price' => '$29.00', 'students' => '3.1k', 'lectures' => 10, 'resources' => 4, 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2426&auto=format&fit=crop'],
                        ['id' => 4, 'title' => 'Data Science for Beginners', 'category' => 'Data', 'price' => '$59.00', 'students' => '1.2k', 'lectures' => 15, 'resources' => 6, 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop'],
                        ['id' => 5, 'title' => 'Python Programming Deep Dive', 'category' => 'Coding', 'price' => '$35.00', 'students' => '5.2k', 'lectures' => 20, 'resources' => 8, 'img' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?q=80&w=2069&auto=format&fit=crop'],
                        ['id' => 6, 'title' => 'Graphic Design Fundamentals', 'category' => 'Design', 'price' => '$40.00', 'students' => '2.1k', 'lectures' => 9, 'resources' => 4, 'img' => 'https://images.unsplash.com/photo-1558655146-d09347e92766?q=80&w=1964&auto=format&fit=crop'],
                        ['id' => 7, 'title' => 'Business Strategy 101', 'category' => 'Business', 'price' => '$49.00', 'students' => '900', 'lectures' => 7, 'resources' => 2, 'img' => 'https://images.unsplash.com/photo-1454165833767-131f72a1a7c1?q=80&w=2070&auto=format&fit=crop'],
                        ['id' => 8, 'title' => 'Digital Photography Master', 'category' => 'Art', 'price' => '$25.00', 'students' => '1.5k', 'lectures' => 11, 'resources' => 5, 'img' => 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=2070&auto=format&fit=crop'],
                    ];
                @endphp

                @foreach($courses as $course)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-xl transition duration-300">

                        <!-- Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $course['img'] }}" alt="{{ $course['title'] }}"
                                class="w-full h-52 object-cover group-hover:scale-105 transition duration-300">

                        </div>

                        <!-- Content -->
                        <div class="p-5">

                            <!-- Title -->
                            <h3
                                class="font-semibold text-slate-900 mb-4 line-clamp-2 min-h-[48px] group-hover:text-zilom-blue transition">
                                {{ $course['title'] }}
                            </h3>

                            <!-- Free Content Info -->
                            <div class="flex items-center justify-between text-sm text-slate-600 mb-4">
                                <div class="flex items-center gap-1">
                                    <i class="fa fa-play-circle text-zilom-blue"></i>
                                    <span><strong>{{ $course['lectures'] }}</strong> free lectures</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <i class="fa fa-file-alt text-zilom-blue"></i>
                                    <span><strong>{{ $course['resources'] }}</strong> resources</span>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                <span class="text-zilom-blue font-bold text-lg">
                                    {{ $course['price'] }}
                                </span>

                                <div class="flex items-center text-xs text-slate-500">
                                    <i class="fa fa-users mr-1"></i>
                                    {{ $course['students'] }}
                                </div>
                            </div>

                            <!-- CTA -->
                            <a href="{{ route('courses.show', ['course' => $course['id']]) }}"
                                class="block text-center mt-4 bg-slate-900 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-zilom-blue transition">
                                View details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Registration Section -->
    <section class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">

        <!-- Decorative Blur -->
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-zilom-blue/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-yellow-400/20 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">

                <!-- LEFT CONTENT -->
                <div class="lg:w-3/5 text-white">
                    <span class="text-blue-400 font-semibold uppercase tracking-widest text-sm">
                        Register Now
                    </span>

                    <h2 class="text-4xl lg:text-5xl font-extrabold mt-4 mb-6 leading-tight">
                        Start Learning Today <br>
                        Get Access to <span class="text-yellow-400">60,000+</span> Courses
                    </h2>

                    <p class="text-slate-300 max-w-xl mb-8">
                        Join thousands of learners upgrading their skills daily. Get free access to premium lectures and
                        resources instantly.
                    </p>

                    <!-- Features -->
                    <div class="grid grid-cols-2 gap-4 mb-10 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="fa fa-check-circle text-yellow-400"></i>
                            <span>Free beginner courses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa fa-check-circle text-yellow-400"></i>
                            <span>Expert instructors</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa fa-check-circle text-yellow-400"></i>
                            <span>Downloadable resources</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa fa-check-circle text-yellow-400"></i>
                            <span>Lifetime access</span>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div
                        class="flex items-start gap-4 p-6 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10 max-w-md">
                        <div class="w-14 h-14 bg-zilom-blue rounded-full flex items-center justify-center text-xl shrink-0">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm italic text-slate-200 mb-2">
                                "Excellent platform! The free content helped me start my career in tech."
                            </p>
                            <p class="font-semibold text-white text-sm">Ronald Richards</p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT FORM -->
                <div class="lg:w-2/5 w-full">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">

                        <h3 class="text-2xl font-bold text-slate-900 mb-2">
                            Create Your Free Account
                        </h3>
                        <p class="text-slate-500 text-sm mb-6">
                            Takes less than 1 minute
                        </p>

                        <form action="#" class="space-y-4">

                            <input type="text" placeholder="Full Name"
                                class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-zilom-blue">

                            <input type="email" placeholder="Email Address"
                                class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-zilom-blue">

                            <input type="text" placeholder="Phone Number"
                                class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-zilom-blue">

                            <textarea placeholder="What do you want to learn?" rows="3"
                                class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-zilom-blue"></textarea>

                            <button
                                class="w-full bg-zilom-blue text-white py-3.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                                Get Free Access
                            </button>
                        </form>

                        <!-- Trust Note -->
                        <p class="text-xs text-slate-400 mt-4 text-center">
                            No credit card required • 100% free courses available
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Top Categories -->
    <!-- <section class="py-20 bg-white">
                        <div class="container mx-auto px-6">
                            <div class="text-center mb-16">
                                <span class="text-zilom-blue font-semibold uppercase tracking-widest text-sm">Hot Categories</span>
                                <h2 class="text-4xl font-bold text-slate-900 mt-3">Top Categories</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @php
                                    $cats = [
                                        ['title' => 'Web Development', 'img' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?q=80&w=1964&auto=format&fit=crop'],
                                        ['title' => 'Graphic Design', 'img' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=2000&auto=format&fit=crop'],
                                        ['title' => 'Business Admin', 'img' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=2071&auto=format&fit=crop'],
                                        ['title' => 'Product Design', 'img' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?q=80&w=2070&auto=format&fit=crop'],
                                    ];
                                @endphp
                                @foreach($cats as $cat)
                                    <div class="category-card group transition-all duration-500 cursor-pointer">
                                        <img src="{{ $cat['img'] }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                            alt="{{ $cat['title'] }}">
                                        <div class="category-overlay">
                                            <h4 class="font-bold text-xl">{{ $cat['title'] }}</h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center mt-12">
                                <a href="#"
                                    class="border border-slate-200 px-8 py-3 rounded-md font-bold text-slate-600 hover:bg-slate-50 transition-all inline-block">
                                    View All Categories
                                </a>
                            </div>
                        </div>
                    </section> -->

    <!-- Testimonials Section -->
    <section class="py-24 w-full bg-gradient-to-br from-blue-900 to-blue-700 text-white relative">

        <!-- Background accents -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white opacity-10 rounded-full blur-2xl"></div>

        <div class="container relative z-10">

            <!-- Heading -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold">What Our Students Say</h2>
            </div>

            <!-- Slider Wrapper -->
            <div class="overflow-visible w-full">
                <div class="flex space-x-8 animate-scroll">

                    @php
                        $testimonials = [
                            [
                                'name' => 'Guy Hawkins',
                                'role' => 'Senior Developer',
                                'image' => 'https://i.pravatar.cc/150?u=1',
                                'text' => '"The platform is incredibly intuitive. I found exactly what I needed. Learning here has been a game-changer for my career path."'
                            ],
                            [
                                'name' => 'Jane Cooper',
                                'role' => 'UI/UX Designer',
                                'image' => 'https://i.pravatar.cc/150?u=2',
                                'text' => '"Amazing courses and very practical learning approach. The projects really helped me build a professional portfolio."'
                            ],
                            [
                                'name' => 'Robert Fox',
                                'role' => 'Marketing Lead',
                                'image' => 'https://i.pravatar.cc/150?u=3',
                                'text' => '"Perfect for switching careers. Loved every bit of it. The support from the instructors is unmatched."'
                            ],
                            [
                                'name' => 'Esther Howard',
                                'role' => 'Frontend Developer',
                                'image' => 'https://i.pravatar.cc/150?u=4',
                                'text' => '"Very engaging content and easy to understand. I was able to learn React from scratch and land my first job."'
                            ],
                            [
                                'name' => 'Wade Warren',
                                'role' => 'Backend Engineer',
                                'image' => 'https://i.pravatar.cc/150?u=5',
                                'text' => '"Support team is amazing and very responsive. Whenever I got stuck, I received help within hours."'
                            ]
                        ];
                    @endphp

                    <!-- First Set of Cards -->
                    @foreach($testimonials as $t)
                        <div
                            class="min-w-[350px] max-w-[350px] bg-white text-gray-800 rounded-2xl p-8 shadow-lg flex flex-col h-[280px]">
                            <p class="italic mb-6 text-gray-600 leading-relaxed overflow-hidden line-clamp-4">
                                {{ $t['text'] }}
                            </p>
                            <div class="flex items-center space-x-3 mt-auto pt-4 border-t border-gray-100">
                                <img src="{{ $t['image'] }}" class="w-12 h-12 rounded-full border-2 border-blue-500 shadow-sm">
                                <div>
                                    <h5 class="font-bold text-slate-900">{{ $t['name'] }}</h5>
                                    <span
                                        class="text-sm text-gray-500 uppercase tracking-wider text-[10px] font-bold">{{ $t['role'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Duplicate Set for Seamless Scroll -->
                    @foreach($testimonials as $t)
                        <div
                            class="min-w-[350px] max-w-[350px] bg-white text-gray-800 rounded-2xl p-8 shadow-lg flex flex-col h-[280px]">
                            <p class="italic mb-6 text-gray-600 leading-relaxed overflow-hidden line-clamp-4">
                                {{ $t['text'] }}
                            </p>
                            <div class="flex items-center space-x-3 mt-auto pt-4 border-t border-gray-100">
                                <img src="{{ $t['image'] }}" class="w-12 h-12 rounded-full border-2 border-blue-500 shadow-sm">
                                <div>
                                    <h5 class="font-bold text-slate-900">{{ $t['name'] }}</h5>
                                    <span
                                        class="text-sm text-gray-500 uppercase tracking-wider text-[10px] font-bold">{{ $t['role'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>

    <style>
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-scroll {
            display: flex;
            width: max-content;
            animation: scroll 25s linear infinite;
        }
    </style>

    <!-- Benefits Section -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <span class="text-zilom-blue font-semibold uppercase tracking-widest text-sm">Why Choose Us</span>
                    <h2 class="text-4xl font-bold text-slate-900 mt-4 mb-8 leading-tight">Benefits Of Learning <br> From
                        Zilom</h2>

                    <div
                        class="flex items-start space-x-6 mb-10 p-6 bg-white rounded-2xl shadow-sm border-l-4 border-zilom-blue">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-zilom-blue flex-shrink-0">
                            <i class="fa fa-chart-line"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl mb-2">Build your career with online courses</h4>
                            <p class="text-slate-600 text-sm">There are many variations of passages of available but the
                                majority have suffered alteration in some form.</p>
                        </div>
                    </div>

                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3 benefit-item">
                            <i class="fa fa-check-square"></i>
                            <span class="text-slate-700 font-medium">Industry-standard curriculum</span>
                        </li>
                        <li class="flex items-center space-x-3 benefit-item">
                            <i class="fa fa-check-square"></i>
                            <span class="text-slate-700 font-medium">Hands-on projects and assignments</span>
                        </li>
                        <li class="flex items-center space-x-3 benefit-item">
                            <i class="fa fa-check-square"></i>
                            <span class="text-slate-700 font-medium">Direct mentorship from trainers</span>
                        </li>
                    </ul>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-yellow-400/20 rounded-full blur-2xl"></div>
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop"
                        class="rounded-3xl shadow-2xl relative z-10" alt="Student Working">
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl z-20">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                                <i class="fa fa-play"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase">Experience</p>
                                <p class="font-bold text-slate-900">Virtual Learning</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection