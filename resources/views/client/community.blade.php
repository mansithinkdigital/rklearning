@extends('layouts.client')
@section('title', 'Community - Rk Institute')

@section('content')
<!-- Hero Section -->
<section class="bg-slate-50 py-20 border-b border-slate-100">
    <div class="container mx-auto px-6 text-center max-w-3xl">
        <div class="inline-block px-4 py-2 bg-indigo-50 text-indigo-600 rounded-full font-semibold text-sm mb-6">
            Join the Network
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6">Join Our Thriving <span class="text-indigo-600">Community</span></h1>
        <p class="text-lg text-slate-600 mb-8">Connect with fellow learners, share ideas, collaborate on projects, and grow your network with RK Institute's global student community.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#" class="btn-join px-8 py-3 text-base flex items-center justify-center">
                <i class="fab fa-discord mr-2 text-xl"></i> Join Discord Server
            </a>
            <a href="#" class="bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 px-8 py-3 rounded-md font-semibold transition-all flex items-center justify-center shadow-sm">
                <i class="fab fa-whatsapp mr-2 text-xl text-green-500"></i> WhatsApp Group
            </a>
        </div>
    </div>
</section>

<!-- Community Highlights -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Why Join The Community?</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">Learning is better together. Discover what you can achieve when you connect with peers and mentors.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Highlight 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow text-center group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa fa-comments"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Discussion Forums</h3>
                <p class="text-slate-600">Ask questions, share resources, and discuss course topics with peers and instructors.</p>
            </div>
            <!-- Highlight 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow text-center group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa fa-users"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Study Groups</h3>
                <p class="text-slate-600">Form or join study groups based on your courses to collaborate and prepare for exams together.</p>
            </div>
            <!-- Highlight 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow text-center group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa fa-calendar-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Exclusive Events</h3>
                <p class="text-slate-600">Get access to community-only webinars, Q&A sessions, and career guidance workshops.</p>
            </div>
        </div>
    </div>
</section>
@endsection
