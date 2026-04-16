@extends('layouts.student')

@section('title', 'My Enrolled Courses')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h3 class="text-2xl font-bold text-slate-800 font-Outfit">My Courses</h3>
        <p class="text-slate-500 font-medium">Continue where you left off.</p>
    </div>
    <div class="relative">
        <input type="text" placeholder="Search my courses..." class="pl-10 pr-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition w-full md:w-64 text-sm font-medium">
        <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700">
        {{ session('success') }}
    </div>
@endif
@if(session('info'))
    <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-700">
        {{ session('info') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($enrolledCourses as $course)
    <div class="group">
        <div class="card !p-0 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
            <div class="relative aspect-video">
                <img src="{{ $course->image }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                    <span class="text-white text-xs font-bold px-2 py-1 bg-blue-600 rounded">Enrolled</span>
                </div>
            </div>
            <div class="p-6">
                <h4 class="font-bold text-slate-800 mb-2 truncate">{{ $course->name }}</h4>
                <div class="flex items-center justify-between text-xs font-bold mb-2">
                    <span class="text-blue-600">{{ $course->subjects_count }} Lessons</span>
                    <span class="text-slate-400">Enrolled</span>
                </div>
                <div class="w-full bg-slate-200 h-1.5 rounded-full">
                    <div class="bg-blue-600 h-1.5 rounded-full w-[35%]"></div>
                </div>
                <div class="mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
                    <a href="{{ route('student.learning', $course->id) }}" class="text-xs font-bold text-blue-600 hover:underline">Start Learning &rarr;</a>
                    
                    @php $hasPdf = $course->paidVideos->whereNotNull('pdf')->first(); @endphp
                    @if($hasPdf)
                        <a href="{{ asset($hasPdf->pdf) }}" download class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded font-bold hover:bg-emerald-100 transition flex items-center gap-1">
                            <i data-lucide="download" class="w-3 h-3"></i> PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full p-10 rounded-3xl border border-dashed border-slate-200 text-center">
        <p class="text-slate-500 mb-4">You haven't enrolled in any courses yet.</p>
        <a href="{{ route('courses') }}" class="btn-primary inline-flex items-center justify-center px-6 py-3">Browse Courses</a>
    </div>
    @endforelse
</div>

@if($availableCourses->count())
    <section class="mt-16">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-slate-800">Available Courses</h3>
                <p class="text-slate-500">Purchase more courses from your dashboard.</p>
            </div>
            <a href="{{ route('courses') }}" class="text-sm font-bold text-blue-600 hover:underline">View all courses</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($availableCourses as $course)
            <div class="group">
                <div class="card !p-0 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
                    <div class="relative aspect-video">
                        <img src="{{ $course->image }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                            <span class="text-white text-xs font-bold px-2 py-1 bg-slate-900/80 rounded">{{ $course->subjects_count }} Lessons</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-slate-800 mb-3 truncate">{{ $course->name }}</h4>
                        <p class="text-slate-500 text-sm mb-4">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                        <div class="flex items-center justify-between text-sm font-bold mb-6">
                            <span class="text-slate-700">{{ $course->price > 0 ? '₹'.number_format($course->price, 2) : 'Free' }}</span>
                            <span class="text-slate-400">{{ $course->students->count() }} enrolled</span>
                        </div>
                        <a href="{{ route('student.courses.checkout', $course->id) }}" class="btn-primary w-full text-center block py-2 text-sm">Enroll Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endif
@endsection
