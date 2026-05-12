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
    @php
    $isInactive = $course->pivot->status === 'inactive';
    $isDisabled = $course->is_expired || $isInactive;
    @endphp
    <div class="group {{ $isDisabled ? 'opacity-75 grayscale' : '' }}">
        <div class="card !p-0 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 {{ $isDisabled ? '' : 'group-hover:-translate-y-1' }}">
            <div class="relative aspect-video">
                <img src="{{ asset('admin/uploads/courseimg/' . $course->image) }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                    @if($course->is_expired)
                    <span class="text-white text-xs font-bold px-2 py-1 bg-red-600 rounded uppercase tracking-widest">Expired</span>
                    @elseif($isInactive)
                    <span class="text-white text-xs font-bold px-2 py-1 bg-rose-600 rounded uppercase tracking-widest">Suspended</span>
                    @else
                    <span class="text-white text-xs font-bold px-2 py-1 bg-emerald-500 rounded uppercase tracking-widest">Active</span>
                    @endif
                </div>
            </div>
            <div class="p-6 pb-4">
                <h4 class="font-bold text-slate-800 mb-2 truncate">{{ $course->name }}</h4>
                <div class="flex items-center justify-between text-xs font-bold mb-2">
                    <span class="text-blue-600">{{ $course->subjects_count }} Lessons</span>
                    <span class="text-slate-400">{{ $course->progress_percent }}% Completed</span>
                </div>
                <div class="w-full bg-slate-200 h-1.5 rounded-full">
                    <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $course->progress_percent }}%"></div>
                </div>
                <div class="mt-4 flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-[11px] font-bold">
                        <div class="px-2 py-1 {{ $course->is_expired ? 'bg-red-50 text-red-700 border-red-100' : 'bg-amber-50 text-amber-700 border-amber-100' }} rounded-lg border flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Expires: {{ $course->expiry_date ? $course->expiry_date->format('d M, Y') : 'N/A' }}
                        </div>
                    </div>
                    @if($isInactive)
                    <div class="p-2 bg-rose-50 text-rose-700 border border-rose-100 rounded-lg text-[10px] font-bold flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        Access suspended due to pending balance.
                    </div>
                    @endif
                </div>

                <!-- Syllabus Accordion -->
                <div class="mt-4 border border-slate-100 rounded-xl overflow-hidden">
                    <button onclick="toggleSyllabus(this)" class="w-full px-4 py-3 bg-slate-50 hover:bg-slate-100 text-left flex justify-between items-center transition-colors">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="list" class="w-4 h-4 text-blue-600"></i> View Course Content
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-300"></i>
                    </button>
                    <div class="syllabus-content hidden bg-white">
                        <div class="max-h-48 overflow-y-auto custom-scrollbar p-4 space-y-4">
                            @forelse($course->subjects as $subject)
                            <div>
                                <h5 class="text-sm font-bold text-slate-800 mb-2 border-b border-slate-100 pb-1">{{ $subject->name }}</h5>
                                <div class="space-y-3 pl-2 border-l-2 border-slate-100">
                                    @foreach($subject->units as $unit)
                                    <div>
                                        <p class="text-[11px] font-black uppercase text-slate-500 tracking-widest mb-1 flex items-center gap-1.5">
                                            <i data-lucide="folder" class="w-3 h-3"></i> {{ $unit->name }}
                                        </p>
                                        <ul class="space-y-1 pl-4 border-l border-slate-50">
                                            @foreach($unit->topics as $topic)
                                            <li class="text-xs text-slate-600 flex items-center gap-2">
                                                <i data-lucide="circle" class="w-1.5 h-1.5 fill-slate-300 text-transparent"></i>
                                                <span class="truncate">{{ $topic->name }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @empty
                            <p class="text-xs text-slate-400 text-center italic">No content available yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4">
                    @if($course->is_expired)
                    <span class="inline-flex items-center justify-center gap-1 px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 rounded-md cursor-not-allowed">
                        Access Expired
                        <i data-lucide="lock" class="w-3 h-3"></i>
                    </span>
                    @elseif($isInactive)
                    <a href="{{ route('student.financials') }}"
                        class="inline-flex items-center justify-center gap-1 px-4 py-2 text-xs font-bold text-rose-600 bg-rose-50 border border-rose-200 rounded-md hover:bg-rose-600 hover:text-white transition duration-200">
                        Clear Balance
                        <i data-lucide="credit-card" class="w-3 h-3"></i>
                    </a>
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

@section('scripts')
<script>
    function toggleSyllabus(btn) {
        const content = btn.nextElementSibling;
        const icon = btn.querySelector('i[data-lucide="chevron-down"]');

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endsection