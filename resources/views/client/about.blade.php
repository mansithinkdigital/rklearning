@extends('layouts.client')

@section('title', 'About Us - Rk Learning Hub')

@section('styles')
<style>
    .section-spacing {
        padding: 100px 0;
    }
    
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-color: #4f46e5;
    }

    .value-item {
        padding: 40px;
        border-radius: 24px;
        background: white;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .value-item:hover {
        border-color: #4f46e5;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }

    .faculty-image-container::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.8), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .faculty-card:hover .faculty-image-container::after {
        opacity: 1;
    }
</style>
@endsection

@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative py-28 md:py-36 overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-indigo-900 via-slate-900 to-black"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center">
            <nav class="inline-flex items-center space-x-3 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md mb-10 transition-all hover:bg-white/10">
                <a href="{{ route('home') }}" class="text-xs font-medium uppercase tracking-wider text-indigo-300 hover:text-white transition">Home</a>
                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-xs font-medium uppercase tracking-wider text-slate-400">About Us</span>
            </nav>

            <h1 class="text-5xl md:text-7xl font-black text-white mb-8 tracking-tight leading-[1.1]">
                Transforming Lives Through <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-blue-400 to-teal-400">
                    Quality Education
                </span>
            </h1>

            <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed mb-10">
                Empowering students with the skills and confidence they need to thrive in the modern professional landscape through innovative learning and expert mentorship.
            </p>

            <div class="flex items-center justify-center space-x-4">
                <div class="h-[1px] w-12 bg-indigo-500/50"></div>
                <span class="text-indigo-300 font-medium tracking-widest text-sm uppercase">Est. 2024</span>
                <div class="h-[1px] w-12 bg-indigo-500/50"></div>
            </div>
        </div>

        <div class="absolute inset-0 opacity-20 mix-blend-overlay pointer-events-none" 
             style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');">
        </div>
    </section>

    <!-- Our Journey Section -->
    <section class="section-spacing bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" 
                         class="rounded-[32px] shadow-2xl relative z-10 w-full object-cover aspect-[4/3] group-hover:scale-[1.02] transition-transform duration-500" alt="Students Collaboration">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-50 rounded-full -z-10 blur-2xl"></div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-50 rounded-full -z-10 blur-2xl"></div>
                </div>
                
                <div>
                    <h5 class="text-indigo-600 font-bold uppercase tracking-[0.2em] text-xs mb-4">Our Legacy</h5>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-8 leading-tight">Elevating Potential <br> Since 2002</h2>
                    <div class="space-y-6 text-slate-600 text-lg leading-relaxed">
                        <p>
                            Starting as a specialized laboratory for technical excellence, Rk Learning Hub has consistently pushed the boundaries of traditional education for over two decades.
                        </p>
                        <p>
                            We believe that education should be as dynamic as the industries it serves. Our methodology centers on <strong>practical application</strong>, ensuring that every concept mastered is directly translatable to real-world success.
                        </p>
                    </div>
                    
                    <div class="mt-12 flex items-center p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex -space-x-3 mr-6">
                            <img src="https://i.pravatar.cc/100?u=1" class="w-12 h-12 rounded-full border-4 border-white shadow-sm" alt="">
                            <img src="https://i.pravatar.cc/100?u=2" class="w-12 h-12 rounded-full border-4 border-white shadow-sm" alt="">
                            <img src="https://i.pravatar.cc/100?u=3" class="w-12 h-12 rounded-full border-4 border-white shadow-sm" alt="">
                        </div>
                        <p class="text-slate-600 font-medium">Trusted by <span class="text-indigo-600 font-bold">50,000+</span> graduates worldwide</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Essential Stats -->
    <section class="py-20 bg-slate-50 border-y border-slate-100">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="stats-card">
                    <h3 class="text-4xl font-black text-indigo-600 mb-2">50K+</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Active Learners</p>
                </div>
                <div class="stats-card">
                    <h3 class="text-4xl font-black text-indigo-600 mb-2">120+</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Global Courses</p>
                </div>
                <div class="stats-card">
                    <h3 class="text-4xl font-black text-indigo-600 mb-2">24</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Years of Excellence</p>
                </div>
                <div class="stats-card">
                    <h3 class="text-4xl font-black text-indigo-600 mb-2">4.9</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Student Rating</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="section-spacing bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-4xl font-black text-slate-900 mb-6 tracking-tight">Core Philosophies</h2>
                <p class="text-slate-500 text-lg">The principles that guide our curriculum and support systems every single day.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="value-item">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-8 text-2xl">
                        <i class="fa fa-lightbulb"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-900 mb-4">Radical Innovation</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">We don't settle for "good enough." Our team constantly updates content to reflect the absolute latest in industry standards.</p>
                </div>

                <div class="value-item">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-8 text-2xl">
                        <i class="fa fa-handshake"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-900 mb-4">Unwavering Integrity</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Trust is our foundation. We maintain complete transparency with our students regarding their progress and career roadmaps.</p>
                </div>

                <div class="value-item">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-8 text-2xl">
                        <i class="fa fa-rocket"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-900 mb-4">Student Velocity</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">We optimize for your time. Every lesson is engineered to provide maximum knowledge density and actionable results.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Faculty Section (Clean & Professional) -->
    <section class="section-spacing bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-xl">
                    <h2 class="text-4xl font-black text-slate-900 mb-6 tracking-tight">Our Academic Council</h2>
                    <p class="text-slate-500 text-lg">Guided by a team of industry veterans dedicated to your professional journey.</p>
                </div>
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-slate-900 font-bold rounded-xl border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition shadow-sm">
                    Connect with Faculty
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Member 1 -->
                <div class="faculty-card group">
                    <div class="faculty-image-container relative overflow-hidden rounded-3xl mb-6 aspect-[4/5] bg-slate-200">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974&auto=format&fit=crop" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Dr. Robert K.">
                        <div class="absolute bottom-6 left-6 right-6 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-1">Dr. Robert K.</h4>
                    <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Founder & Dean</p>
                </div>

                <!-- Member 2 -->
                <div class="faculty-card group">
                    <div class="faculty-image-container relative overflow-hidden rounded-3xl mb-6 aspect-[4/5] bg-slate-200">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976&auto=format&fit=crop" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Sarah Johnson">
                        <div class="absolute bottom-6 left-6 right-6 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-1">Sarah Johnson</h4>
                    <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Head of Education</p>
                </div>

                <!-- Member 3 -->
                <div class="faculty-card group">
                    <div class="faculty-image-container relative overflow-hidden rounded-3xl mb-6 aspect-[4/5] bg-slate-200">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1974&auto=format&fit=crop" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Marcus Chen">
                        <div class="absolute bottom-6 left-6 right-6 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-1">Marcus Chen</h4>
                    <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Technical Lead</p>
                </div>

                <!-- Member 4 -->
                <div class="faculty-card group">
                    <div class="faculty-image-container relative overflow-hidden rounded-3xl mb-6 aspect-[4/5] bg-slate-200">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961&auto=format&fit=crop" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Elena Rodriguez">
                        <div class="absolute bottom-6 left-6 right-6 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-indigo-600 transition"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-1">Elena Rodriguez</h4>
                    <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Lead Instructor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Logo Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <p class="text-center text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px] mb-12">Institutional Synergies</p>
            <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-30 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-700">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/2560px-Google_2015_logo.svg.png" class="h-6 w-auto" alt="Google">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/IBM_logo.svg/2560px-IBM_logo.svg.png" class="h-8 w-auto" alt="IBM">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Amazon_logo.svg/2560px-Amazon_logo.svg.png" class="h-6 w-auto" alt="Amazon">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Netflix_2015_logo.svg/2560px-Netflix_2015_logo.svg.png" class="h-6 w-auto" alt="Netflix">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/Microsoft_logo_%282012%29.svg/2560px-Microsoft_logo_%282012%29.svg.png" class="h-6 w-auto" alt="Microsoft">
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="section-spacing bg-white">
        <div class="container mx-auto px-6">
            <div class="bg-indigo-600 rounded-[3rem] p-12 md:p-24 text-center relative overflow-hidden shadow-2xl shadow-indigo-200">
                <!-- Abstract BG Accents -->
                <div class="absolute -top-20 -left-20 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-black opacity-10 rounded-full blur-3xl"></div>
                
                <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight">Begin Your <br> Evolution Today.</h2>
                <p class="text-indigo-100 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed">Join 50,000+ students already reshaping their careers with our award-winning curriculum.</p>
                <div class="flex flex-wrap justify-center gap-6 relative z-10">
                    <a href="{{ route('courses') }}" class="px-12 py-5 bg-white text-indigo-600 font-extrabold rounded-2xl hover:scale-[1.05] transition-transform shadow-xl">
                        Explore Curriculum
                    </a>
                    <a href="{{ route('contact') }}" class="px-12 py-5 bg-indigo-700 text-white font-extrabold rounded-2xl hover:bg-indigo-800 transition-colors border border-indigo-400/30">
                        Contact Admissions
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
