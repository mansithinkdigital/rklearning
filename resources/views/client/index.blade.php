@extends('layouts.client')

@section('title', 'Welcome to Rk Learning Hub - From Classroom to Cloud')

@section('styles')
<style>
    .hero-section {
        padding: 100px 0;
        background: radial-gradient(circle at 90% 10%, rgba(59, 130, 246, 0.05) 0%, transparent 40%),
                    radial-gradient(circle at 10% 90%, rgba(251, 191, 36, 0.05) 0%, transparent 40%);
        min-height: 80vh;
        display: flex;
        align-items: center;
    }

    .hero-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(29, 78, 216, 0.1);
        color: var(--primary);
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 3.5rem;
        line-height: 1.1;
        margin-bottom: 24px;
        color: var(--secondary);
    }

    .hero-title span {
        color: var(--primary);
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .course-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .course-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }

    .rating-badge {
        background: #FEF3C7;
        color: #D97706;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 700;
    }

    .section-header {
        max-width: 600px;
        margin: 0 auto 60px;
        text-align: center;
    }

    .testimonial-card {
        background: #F1F5F9;
        padding: 40px;
        border-radius: 30px;
        position: relative;
    }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: 20px;
        left: 30px;
        font-size: 80px;
        color: rgba(29, 78, 216, 0.1);
        font-family: serif;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="animate-fade-in">
            <span class="hero-badge">Online Learning Platform</span>
            <h1 class="hero-title Outfit">
                A 24-Year Legacy <br>
                <span>Now From Classroom To Cloud.</span>
            </h1>
            <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                Expert training designed to empower your career path. Join thousands of students who have transformed their lives through our courses.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#" class="btn-primary flex items-center">
                    Watch Now <i class="fa fa-play-circle ml-2"></i>
                </a>
                <a href="#" class="px-8 py-3 border-2 border-primary text-primary font-bold rounded-full hover:bg-primary hover:text-white transition-all flex items-center">
                    Popular Courses
                </a>
            </div>

            <!-- Stats Mini -->
            <div class="grid grid-cols-3 gap-6 mt-16">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">10k+</h3>
                    <p class="text-sm text-slate-500">Students</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">20+</h3>
                    <p class="text-sm text-slate-500">Online Courses</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">24/7</h3>
                    <p class="text-sm text-slate-500">Support</p>
                </div>
            </div>
        </div>
        <div class="relative animate-fade-in" style="animation-delay: 0.2s">
            <div class="relative z-10">
                <img src="{{ asset('assets/images/hero.png') }}" alt="Student Learning" class="w-full h-auto rounded-3xl">
            </div>
            <!-- Decorative elements -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-yellow-400 opacity-20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-600 opacity-10 rounded-full blur-3xl"></div>
        </div>
    </div>
</section>

<!-- Features section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="stat-card flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-primary text-xl">
                    <i class="fa fa-globe"></i>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Global Learning</h4>
                    <p class="text-sm text-slate-500">Access quality education from anywhere in the world.</p>
                </div>
            </div>
            <div class="stat-card flex items-start space-x-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600 text-xl">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Expert Instructors</h4>
                    <p class="text-sm text-slate-500">Learn from industry experts with real-world experience.</p>
                </div>
            </div>
            <div class="stat-card flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-xl">
                    <i class="fa fa-clock"></i>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Lifetime Access</h4>
                    <p class="text-sm text-slate-500">Study at your own pace with lifetime access to materials.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Courses -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="section-header">
            <span class="text-primary font-bold uppercase tracking-widest text-sm">Popular Courses</span>
            <h2 class="text-4xl mt-3 mb-4 Outfit">Our Popular Online Courses</h2>
            <p class="text-slate-500">Explore our most requested courses and start your learning journey today.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Course Card 1 -->
            <div class="course-card">
                <div class="relative">
                    <img src="{{ asset('assets/images/course1.png') }}" alt="Web Dev" class="course-img">
                    <div class="absolute top-4 left-4">
                        <span class="bg-primary text-white text-xs px-3 py-1 rounded-full font-bold">Best Seller</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="rating-badge"><i class="fa fa-star text-[10px] mr-1"></i> 4.9 (2.1k Reviews)</span>
                        <span class="text-primary font-bold">$79.99</span>
                    </div>
                    <h3 class="text-xl mb-3 Outfit">Complete Web Development Bootcamp</h3>
                    <div class="flex items-center text-slate-500 text-xs space-x-4 mb-6">
                        <span><i class="fa fa-book-open mr-1"></i> 45 Lessons</span>
                        <span><i class="fa fa-users mr-1"></i> 5.2k Students</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=RK&background=1D4ED8&color=fff" class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm font-medium">RK Academy</span>
                        </div>
                        <a href="#" class="btn-primary py-2 px-6 text-sm">Join Now</a>
                    </div>
                </div>
            </div>

            <!-- More placeholders can be added here -->
             <div class="course-card">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1586717791821-3f44a563cc4c?q=80&w=2070&auto=format&fit=crop" alt="UI UX" class="course-img">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="rating-badge"><i class="fa fa-star text-[10px] mr-1"></i> 4.8 (1.5k Reviews)</span>
                        <span class="text-primary font-bold">$49.99</span>
                    </div>
                    <h3 class="text-xl mb-3 Outfit">Advanced UI/UX Design Masterclass</h3>
                    <div class="flex items-center text-slate-500 text-xs space-x-4 mb-6">
                        <span><i class="fa fa-book-open mr-1"></i> 32 Lessons</span>
                        <span><i class="fa fa-users mr-1"></i> 3.1k Students</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=RK&background=1D4ED8&color=fff" class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm font-medium">RK Academy</span>
                        </div>
                        <a href="#" class="btn-primary py-2 px-6 text-sm">Join Now</a>
                    </div>
                </div>
            </div>

            <div class="course-card">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop" alt="Data Science" class="course-img">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="rating-badge"><i class="fa fa-star text-[10px] mr-1"></i> 5.0 (890 Reviews)</span>
                        <span class="text-primary font-bold">$129.99</span>
                    </div>
                    <h3 class="text-xl mb-3 Outfit">Data Science & Machine Learning Pro</h3>
                    <div class="flex items-center text-slate-500 text-xs space-x-4 mb-6">
                        <span><i class="fa fa-book-open mr-1"></i> 60 Lessons</span>
                        <span><i class="fa fa-users mr-1"></i> 1.8k Students</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=RK&background=1D4ED8&color=fff" class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm font-medium">RK Academy</span>
                        </div>
                        <a href="#" class="btn-primary py-2 px-6 text-sm">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <a href="#" class="font-bold text-primary hover:underline">View All Courses <i class="fa fa-arrow-right ml-1"></i></a>
        </div>
    </div>
</section>

<!-- Why Choose Us / Service -->
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <span class="text-primary font-bold uppercase tracking-widest text-sm">Why Choose Us</span>
            <h2 class="text-4xl mt-3 mb-6 Outfit">Online Education Tailored to You</h2>
            <p class="text-slate-600 mb-8 leading-relaxed">
                We provide a comprehensive learning experience that combines theoretical knowledge with practical application. Our platform is designed to help you achieve your career goals.
            </p>
            <ul class="space-y-4 mb-10">
                <li class="flex items-center space-x-3">
                    <div class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-[10px]">
                        <i class="fa fa-check"></i>
                    </div>
                    <span class="font-medium">Industry-standard curriculum</span>
                </li>
                <li class="flex items-center space-x-3">
                    <div class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-[10px]">
                        <i class="fa fa-check"></i>
                    </div>
                    <span class="font-medium">Hands-on projects and assignments</span>
                </li>
                <li class="flex items-center space-x-3">
                    <div class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-[10px]">
                        <i class="fa fa-check"></i>
                    </div>
                    <span class="font-medium">Direct mentorship from trainers</span>
                </li>
            </ul>
            <a href="#" class="btn-primary">Learn More About Us</a>
        </div>
        <div class="relative">
            <div class="bg-white p-8 rounded-[40px] shadow-2xl relative z-10">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" class="w-full h-auto rounded-[30px]" alt="Team">
            </div>
            <!-- Floating element -->
            <div class="absolute -bottom-10 -right-10 bg-white p-6 rounded-2xl shadow-xl z-20 hidden md:block">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-900">Success Rate</h5>
                        <p class="text-sm text-slate-500">98% Satisfied Students</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="section-header">
            <h2 class="text-4xl Outfit">Testimonials from Our Achievers</h2>
        </div>
        
        <div class="max-w-4xl mx-auto testimonial-card">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <img src="https://ui-avatars.com/api/?name=John+Doe&size=200&background=random" class="w-32 h-32 rounded-full border-4 border-white shadow-xl">
                <div>
                    <p class="text-lg italic text-slate-700 mb-6">
                        "The courses at Rk Learning Hub are top-notch. I transitioned from a customer service role to a Junior Web Developer in just 6 months. The mentors are incredibly helpful and the community is great."
                    </p>
                    <h5 class="font-bold text-slate-900">John Doe</h5>
                    <p class="text-sm text-primary">Web Developer at TechCorp</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter / CTA -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="bg-primary rounded-[50px] p-12 lg:p-20 relative overflow-hidden text-center text-white">
             <!-- Abstract shapes -->
             <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
             <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full translate-x-1/3 translate-y-1/3"></div>

            <h2 class="text-4xl md:text-5xl mb-6 Outfit relative z-10">Start Your Learning Journey Today</h2>
            <p class="text-lg text-blue-100 mb-10 max-w-2xl mx-auto relative z-10">Join over 10,000 students learning everyday with us. Get access to premium courses and start building your future.</p>
            
            <div class="flex flex-wrap justify-center gap-4 relative z-10">
                <a href="#" class="bg-white text-primary px-10 py-4 rounded-full font-bold text-lg hover:bg-slate-100 transition shadow-xl">Join Now For Free</a>
                <a href="#" class="bg-transparent border-2 border-white/30 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white/10 transition">Contact Representative</a>
            </div>
        </div>
    </div>
</section>
@endsection
