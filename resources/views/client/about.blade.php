@extends('layouts.client')

@section('title', 'About Us - Rk Learning Hub')

@section('content')
<!-- Page Header -->
<section class="py-20 bg-secondary text-white relative">
    <div class="container mx-auto px-6 text-center relative z-10">
        <h1 class="text-5xl Outfit mb-4">About Rk Learning Hub</h1>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto">Discover our story, our mission, and the passion that drives us to deliver world-class online education.</p>
    </div>
    <!-- Abstract background -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
</section>

<!-- Our Story -->
<section class="py-20">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div>
            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop" class="rounded-[40px] shadow-2xl" alt="Classroom">
        </div>
        <div>
            <span class="text-primary font-bold uppercase tracking-widest text-sm">Our Legacy</span>
            <h2 class="text-4xl mt-3 mb-6 Outfit">24 Years of Educational Excellence</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Founded in 2002, Rk Learning Hub began as a small classroom with a big vision: to make quality education accessible to everyone. Over more than two decades, we have evolved from traditional classroom teaching to a state-of-the-art digital learning platform.
            </p>
            <p class="text-slate-600 mb-8 leading-relaxed">
                Our transition to the cloud wasn't just about technology; it was about reaching learners wherever they are, breaking geographical barriers, and providing the tools needed for success in the modern digital economy.
            </p>
            
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h4 class="text-3xl font-bold text-primary mb-1">500+</h4>
                    <p class="text-sm text-slate-500 uppercase tracking-wide">Graduates</p>
                </div>
                <div>
                    <h4 class="text-3xl font-bold text-primary mb-1">50+</h4>
                    <p class="text-sm text-slate-500 uppercase tracking-wide">Expert Mentors</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl Outfit mb-4">Our Core Values</h2>
            <p class="text-slate-500 max-w-2xl mx-auto">The principles that guide everything we do at Rk Learning Hub.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-primary text-2xl mb-6">
                    <i class="fa fa-lightbulb"></i>
                </div>
                <h4 class="text-xl mb-4 Outfit">Innovation</h4>
                <p class="text-slate-500 text-sm leading-relaxed">We constantly evolve our teaching methods and platform features to provide the best learning experience.</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 text-2xl mb-6">
                    <i class="fa fa-handshake"></i>
                </div>
                <h4 class="text-xl mb-4 Outfit">Integrity</h4>
                <p class="text-slate-500 text-sm leading-relaxed">We maintain the highest standards of academic honesty and professional ethics in all our courses.</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 text-2xl mb-6">
                    <i class="fa fa-heart"></i>
                </div>
                <h4 class="text-xl mb-4 Outfit">Student Success</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Your success is our primary metric. We go above and beyond to ensure our students achieve their goals.</p>
            </div>
        </div>
    </div>
</section>
@endsection
