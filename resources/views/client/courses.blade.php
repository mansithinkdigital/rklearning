@extends('layouts.client')

@section('title', 'Academic Courses - RK Learning Hub')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --accent: #f43f5e;
        --surface: #ffffff;
        --background: #f8fafc;
        --text-main: #0f172a;
        --text-muted: #64748b;
    }

    .lms-modern {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--background);
        color: var(--text-main);
    }

    /* Hero Section with Mesh Gradient */
    .hero-section {
        background: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(244, 63, 94, 0.1) 0px, transparent 50%),
                    #ffffff;
        padding: 100px 0 120px;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    }

    /* Floating Search Bar */
    .search-container {
        margin-top: -40px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.8);
    }

    /* Refined Course Card */
    .course-card {
        background: var(--surface);
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -12px rgba(15, 23, 42, 0.12);
        border-color: var(--primary);
    }

    .image-wrapper {
        position: relative;
        padding: 12px;
    }

    .course-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 18px;
    }

    .price-tag {
        position: absolute;
        bottom: 24px;
        right: 24px;
        background: rgba(15, 23, 42, 0.9);
        backdrop-filter: blur(4px);
        color: white;
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
    }

    /* Single Action Button */
    .btn-view-details {
        background: var(--primary);
        color: white;
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    .btn-view-details:hover {
        background: var(--primary-dark);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        transform: scale(1.02);
    }

    .btn-view-details:active {
        transform: scale(0.98);
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .line-clamp-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 3.5rem;
    }
</style>

<div class="lms-modern min-h-screen">
    <section class="hero-section">
        <div class="container mx-auto px-6 text-center lg:text-left">
            <div class="max-w-4xl">
                <span class="inline-block py-1 px-4 rounded-full bg-indigo-50 text-indigo-600 text-sm font-bold mb-6">
                    🚀 Elevate Your Learning Journey
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight text-slate-900">
                    Master Skills that <span class="text-indigo-600">Matter.</span>
                </h1>
                <p class="text-slate-500 text-lg md:text-xl font-medium max-w-2xl leading-relaxed">
                    Access world-class education from the comfort of your home. Explore our curated list of academic excellence programs.
                </p>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-6">
        <div class="search-container p-3 rounded-3xl shadow-2xl border border-white flex flex-col md:flex-row gap-3 items-center">
            <div class="relative flex-1 w-full">
                <i class="fa fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="What do you want to learn today?" 
                       class="w-full pl-14 pr-6 py-4 bg-transparent border-none focus:ring-0 text-lg font-medium">
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button class="flex-1 md:flex-none px-8 py-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition">
                    Categories
                </button>
                <button class="flex-1 md:flex-none bg-slate-900 px-8 py-4 rounded-2xl font-bold text-white hover:shadow-lg transition">
                    Search
                </button>
            </div>
        </div>
    </div>

    <section class="py-24">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Popular Courses</h2>
                    <div class="h-1.5 w-20 bg-indigo-600 rounded-full"></div>
                </div>
                <p class="text-slate-400 font-semibold uppercase tracking-widest text-xs">
                    Current Inventory: {{ $courses->count() }} Programs
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                @forelse($courses as $course)
                <div class="course-card">
                    <div class="image-wrapper">
                        <img src="{{ asset('admin/uploads/courseimg/'.($course->image)) }}" alt="{{ $course->name }}" class="course-image">
                        <div class="price-tag">
                            @if($course->price > 0)
                                ₹{{ number_format($course->price) }}
                            @else
                                FREE
                            @endif
                        </div>
                    </div>
                    
                    <div class="px-7 pb-7 pt-2 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="stat-badge"><i class="fa fa-star text-amber-400"></i> 4.9</span>
                            <span class="stat-badge"><i class="fa fa-user-graduate"></i> {{ $course->students->count() }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-title">
                            {{ $course->name }}
                        </h3>
                        
                        <p class="text-slate-500 text-sm font-medium mb-8 line-clamp-2">
                            {{ strip_tags($course->description) }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn-view-details">
                                View Course Details
                                <i class="fa fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-32 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-100 mb-6">
                        <i class="fa fa-book-open text-slate-300 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800">No courses found</h3>
                    <p class="text-slate-500 mt-2">Try adjusting your search or check back later.</p>
                </div>
                @endforelse
            </div>

            @if($courses->count() > 0)
            <div class="mt-24 flex justify-center">
                <div class="flex items-center space-x-2 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
                    <button class="p-3 hover:bg-slate-50 rounded-xl transition text-slate-400"><i class="fa fa-chevron-left"></i></button>
                    <button class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-bold">1</button>
                    <button class="w-12 h-12 rounded-xl hover:bg-slate-50 text-slate-600 font-bold">2</button>
                    <button class="p-3 hover:bg-slate-50 rounded-xl transition text-slate-400"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection