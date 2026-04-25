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
    {{-- Approved Courses --}}
    @foreach($enrolledCourses as $course)
    <div class="group {{ $course->is_expired ? 'opacity-75 grayscale' : '' }}">
        <div class="card !p-0 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 {{ $course->is_expired ? '' : 'group-hover:-translate-y-1' }}">
            <div class="relative aspect-video">
                <img src="{{ asset('admin/uploads/courseimg/' . $course->image) }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                    @if($course->is_expired)
                        <span class="text-white text-xs font-bold px-2 py-1 bg-red-500 rounded">Expired</span>
                    @else
                        <span class="text-white text-xs font-bold px-2 py-1 bg-emerald-500 rounded">Active</span>
                    @endif
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
                <div class="mt-4 flex items-center gap-2 text-[11px] font-bold">
                    <div class="px-2 py-1 {{ $course->is_expired ? 'bg-red-50 text-red-700 border-red-100' : 'bg-amber-50 text-amber-700 border-amber-100' }} rounded-lg border flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-3 h-3"></i>
                        Expires: {{ $course->expiry_date ? $course->expiry_date->format('d M, Y') : 'N/A' }}
                    </div>
                </div>
                <div class="mt-2 flex items-center justify-between border-t border-slate-50 pt-4">
                    @if($course->is_expired)
                        <span class="inline-flex items-center justify-center gap-1 px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 rounded-md cursor-not-allowed">
                            Access Expired
                            <i data-lucide="lock" class="w-3 h-3"></i>
                        </span>
                    @else
                        <a href="{{ route('student.learning', $course->id) }}"
                            class="inline-flex items-center justify-center gap-1 px-4 py-2 text-xs font-bold text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-600 hover:text-white transition duration-200">
                            Start Learning
                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    @endif

                    @php $hasPdf = $course->paidVideos->whereNotNull('pdf')->first(); @endphp
                    @if($hasPdf && !$course->is_expired)
                    <a href="{{ asset($hasPdf->pdf) }}" download class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded font-bold hover:bg-emerald-100 transition flex items-center gap-1">
                        <i data-lucide="download" class="w-3 h-3"></i> PDF
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Pending/Offline Requests --}}
    @foreach($pendingCourses as $course)
    <div class="group opacity-80">
        <div class="card !p-0 overflow-hidden shadow-sm border-amber-100 bg-amber-50/10">
            <div class="relative aspect-video transition-all grayscale group-hover:grayscale-0">
                <img src="{{ asset('admin/uploads/courseimg/' . $course->image) }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center p-4">
                    <div class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl text-center shadow-2xl">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-600 mx-auto mb-1"></i>
                        <p class="text-[10px] font-black uppercase tracking-widest text-amber-600 leading-none">Approval Pending</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <h4 class="font-bold text-slate-400 mb-2 truncate">{{ $course->name }}</h4>
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 mt-2">
                    <div class="flex gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-amber-600 shrink-0"></i>
                        <p class="text-[11px] font-bold text-amber-700 leading-relaxed">
                            Admin has not accepted the request yet. Your access will be enabled once the payment is verified.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($enrolledCourses->isEmpty() && $pendingCourses->isEmpty())
    <div class="col-span-full p-16 rounded-[2.5rem] border-2 border-dashed border-slate-100 text-center bg-slate-50/30">
        <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6">
            <i data-lucide="book-open" class="w-10 h-10 text-slate-200"></i>
        </div>
        <h4 class="text-xl font-bold text-slate-800 mb-2">No active courses</h4>
        <p class="text-slate-500 mb-8 max-w-sm mx-auto">You haven't enrolled in any courses yet. Start your journey today!</p>
        <a href="{{ route('courses') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20">
            Browse Our Catalog
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
    @endif
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
                    <img src="{{ asset('admin/uploads/courseimg/' . $course->image) }}" class="w-full h-full object-cover">
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
                    <a href="{{ route('courses.show', $course->id) }}" class="btn-primary w-full text-center block py-2 text-sm border border-black !border-black rounded-md">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@endsection