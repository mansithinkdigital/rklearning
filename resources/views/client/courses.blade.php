@extends('layouts.client')

@section('title', 'Browse Courses - Rk Learning Hub')
@section('content')
<!-- Search & Filter -->
<section class="py-12 bg-white border-b">
    <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
        <h1 class="text-3xl Outfit">Explore All Courses</h1>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:w-80">
                <input type="text" placeholder="Search courses..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
            <button class="bg-slate-100 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <i class="fa fa-sliders"></i>
            </button>
        </div>
    </div>
</section>

<!-- Course List -->
<section class="py-16">
    <div class="container mx-auto px-6">
        @php
            $enrolledCourseIds = Auth::check() ? auth()->user()->courses->modelKeys() : [];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($courses as $course)
            <div class="course-card">
                <div class="relative">
                    <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" class="course-img">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="rating-badge"><i class="fa fa-star text-[10px] mr-1"></i> 4.{{ rand(5,9) }}</span>
                        <span class="text-primary font-bold">
                            @if($course->price > 0)
                                ₹{{ number_format($course->price, 2) }}
                            @else
                                Free
                            @endif
                        </span>
                    </div>
                    <h3 class="text-lg mb-3 Outfit line-clamp-2">{{ $course->name }}</h3>
                    <p class="text-slate-500 text-sm mb-4">{{ \Illuminate\Support\Str::limit($course->description, 90) }}</p>
                    <div class="flex items-center text-slate-500 text-[10px] space-x-3 mb-6">
                        <span><i class="fa fa-book-open mr-1"></i> {{ $course->subjects->count() }} Lessons</span>
                        <span><i class="fa fa-users mr-1"></i> {{ max(1, $course->students->count()) }}k Students</span>
                    </div>
                    <div class="border-t pt-4 space-y-3">
                        <a href="{{ route('courses.show', $course->id) }}" class="block text-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">View Details</a>
                        @auth
                            @if(in_array($course->id, $enrolledCourseIds))
                                <a href="{{ route('student.learning', $course->id) }}" class="btn-primary w-full text-center block py-2 text-sm">Go to Course</a>
                            @else
                                <form action="{{ route('student.courses.purchase', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full text-center block py-2 text-sm">Purchase Now</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('student.login') }}" class="btn-primary w-full text-center block py-2 text-sm">Login to Purchase</a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-slate-500">No courses are available right now. Check back later.</p>
            </div>
            @endforelse
        </div>
        <div class="mt-16 flex justify-center space-x-2">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border text-slate-600 hover:bg-primary hover:text-white transition">1</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white">2</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border text-slate-600 hover:bg-primary hover:text-white transition">3</a>
            <span class="w-10 h-10 flex items-center justify-center text-slate-400">...</span>
            <hr class="hidden sm:block">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border text-slate-600 hover:bg-primary hover:text-white transition"><i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</section>
@endsection
