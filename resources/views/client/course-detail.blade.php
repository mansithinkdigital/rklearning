@extends('layouts.client')
@section('title', $course->name . ' - Course Overview | RK Institute')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .lms-details {
        font-family: 'Outfit', sans-serif;
        background-color: #fcfcfd;
        color: #1e293b;
    }

    .details-hero {
        background: #0f172a;
        padding: 60px 0 120px;
        color: white;
        position: relative;
    }

    .content-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .syllabus-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .syllabus-btn:hover {
        border-color: #2563eb;
        background: #ffffff;
    }

    .sticky-enroll {
        position: sticky;
        top: 2rem;
    }

    .enroll-action-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .btn-enroll {
        background: #2563eb;
        color: white;
        width: 100%;
        padding: 18px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-enroll:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .icon-box {
        width: 40px;
        height: 40px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .badge-premium {
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div class="lms-details min-h-screen">
    <!-- Breadcrumb & Title Hero -->
    <section class="details-hero">
        <div class="container mx-auto px-6">
            <nav class="flex items-center gap-2 text-slate-400 text-xs font-bold mb-8">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i class="fa fa-chevron-right text-[8px]"></i>
                <a href="{{ route('courses') }}" class="hover:text-white transition">Courses</a>
                <i class="fa fa-chevron-right text-[8px]"></i>
                <span class="text-white">{{ $course->name }}</span>
            </nav>
            <div class="max-w-4xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="badge-premium">Official Certification</span>
                    <span class="text-slate-500 text-xs font-bold"></span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-8">{{ $course->name }}</h1>
                <p class="text-slate-400 text-xl font-medium max-w-2xl leading-relaxed">{{ strip_tags($course->description) }}</p>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="container mx-auto px-6 -mt-20 relative z-10 pb-32">
        <div class="grid lg:grid-cols-12 gap-10">
            <!-- Left: Course Information -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Summary Stats -->
                <div class="content-card p-10 grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Subjects</p>
                        <p class="text-lg font-black text-slate-900">{{ $course->subjects->count() }} Modules</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Duration</p>
                        <p class="text-lg font-black text-slate-900">{{ $course->duration }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Language</p>
                        <p class="text-lg font-black text-slate-900">{{ $course->language }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Enrolled</p>
                        <p class="text-lg font-black text-slate-900">{{ $course->students->count() }}+</p>
                    </div>
                </div>

                <!-- curriculum Accordion -->
                <div class="content-card p-10">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-slate-50">
                        <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Detailed Curriculum</h2>
                    </div>

                    <div class="space-y-4">
                        @forelse($course->subjects as $subject)
                        <div class="overflow-hidden">
                            <button onclick="toggleCurriculum({{ $subject->id }}, this)" class="syllabus-btn w-full px-8 py-6 flex items-center justify-between group">
                                <div class="flex items-center gap-5">
                                    <div class="icon-box group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <i class="fa fa-layer-group text-sm"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Module</p>
                                        <h4 class="text-lg font-bold text-slate-800 tracking-tight uppercase">{{ $subject->name }}</h4>
                                    </div>
                                    @section('title', $course->name . ' - Course Detail')
                                    @section('content')
                                    <section class="py-20 bg-slate-50">
                                        <div class="container mx-auto px-6">
                                            <div class="grid gap-12 lg:grid-cols-3">
                                                <div class="lg:col-span-2 space-y-10">
                                                    <div class="rounded-[2rem] overflow-hidden shadow-xl">
                                                        <img src="{{ asset('admin/uploads/courseimg/'.$course->image) }}" alt="{{ $course->name }}" class="w-full h-[420px] object-cover">
                                                    </div>
                                                    <div class="bg-white rounded-[2rem] p-10 shadow-lg">
                                                        <h2 class="text-3xl font-black text-slate-900 mb-6">Course Curriculum & Resources</h2>
                                                        <div class="space-y-6">
                                                            @forelse($course->paidVideos as $index => $video)
                                                            <div class="flex items-center justify-between p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-all">
                                                                <div class="flex items-center gap-4">
                                                                    <div class="w-12 h-12 rounded-xl bg-blue-600/10 flex items-center justify-center text-blue-600 font-bold">
                                                                        {{ $index + 1 }}
                                                                    </div>
                                                                    <i id="icon-subject-{{ $subject->id }}" class="fa fa-chevron-down text-slate-300 transition-transform"></i>
                            </button>

                            <div id="subject-{{ $subject->id }}" class="hidden px-6 pt-4 pb-8 border-x border-b border-slate-50 rounded-b-2xl animate-in slide-in-from-top-2">
                                <div class="grid md:grid-cols-2 gap-6">
                                    @foreach($subject->units as $unit)
                                    <div class="bg-slate-50 p-6 rounded-2xl border border-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ $unit->name }}</span>
                                            <i class="fa fa-check-circle text-emerald-500 text-xs"></i>
                                        </div>
                                        <ul class="space-y-2">
                                            @foreach($unit->topics as $topic)
                                            <li class="flex items-start text-xs font-bold text-slate-600">
                                                <i class="fa fa-circle text-[6px] text-slate-300 mt-1.5 mr-3"></i>
                                                {{ $topic->name }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No curriculum defined for this program</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Extended Info -->
                <div class="content-card p-10">
                    <div class="flex items-center gap-4 mb-1 pb-6 border-b border-slate-50">
                        <div class="w-1.5 h-8 bg-amber-600 rounded-full"></div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Program Highlights</h2>
                    </div>
                    <div class="prose prose-slate max-w-none text-slate-600 mt-0 font-medium leading-relaxed 
            [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6">
                        {!! $course->long_description !!}
                    </div>
                </div>
            </div>

            <!-- Right: Dynamic Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky-enroll">
                    <div class="enroll-action-card p-10">
                        <div class="mb-10 text-center">
                            <p class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Total investment</p>
                            <p class="text-6xl font-black text-slate-900 tracking-tighter">
                                @if($course->price > 0)
                                <span class="text-2xl align-top mt-2 inline-block">₹</span>{{ number_format($course->price) }}
                                @else
                                FREE
                                @endif
                            </p>
                        </div>

                        <div class="space-y-4 mb-10">
                            @auth
                            @if($hasPurchased)
                            <a href="{{ route('student.learning', $course->id) }}" class="btn-enroll bg-emerald-600 hover:bg-emerald-700 shadow-xl shadow-emerald-100">
                                <i class="fa fa-play text-xs"></i> Resume Learning
                            </a>
                            @elseif($isPending)
                            <div class="p-6 rounded-2xl bg-amber-50 border border-amber-100 text-center">
                                <p class="text-xs font-black text-amber-600 uppercase tracking-widest mb-1">Status: Pending</p>
                                <p class="text-[10px] text-amber-500 font-bold">Waiting for admin approval</p>
                            </div>
                            @else
                            <a href="{{ route('student.courses.checkout', $course->id) }}" class="btn-enroll">
                                Secure Enrollment Now
                            </a>
                            @endif
                            @else
                            <a href="{{ route('login') }}?redirect_to={{ urlencode(route('student.courses.checkout', $course->id)) }}" class="btn-enroll bg-slate-900 hover:bg-black">
                                Buy Now
                            </a>
                            @endauth
                        </div>

                        <ul class="space-y-6 pt-10 border-t border-slate-50">
                            <li class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400"><i class="fa fa-infinity text-sm"></i></div>
                                <div>
                                    <h5 class="text-xs font-black text-slate-800 uppercase tracking-tight">Lifetime Pass</h5>
                                    <p class="text-[10px] text-slate-500 font-medium">Never expiring access to modules</p>
                                </div>
                            </li>
                            <li class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400"><i class="fa fa-certificate text-sm"></i></div>
                                <div>
                                    <h5 class="text-xs font-black text-slate-800 uppercase tracking-tight">Verification</h5>
                                    <p class="text-[10px] text-slate-500 font-medium">Industry recognized certification</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8 p-8 bg-blue-600 rounded-[2.5rem] text-white shadow-xl shadow-blue-100">
                        <h4 class="text-lg font-black mb-2 uppercase leading-tight italic">Enroll with Confidence</h4>
                        <p class="text-blue-100 text-xs font-medium leading-relaxed">Join thousands of students who have transformed their careers with RK Institute.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleCurriculum(id, btn) {
        const el = document.getElementById(`subject-${id}`);
        const icon = btn.querySelector(`#icon-subject-${id}`);
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            icon.style.color = '#2563eb';
        } else {
            el.classList.add('hidden');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
            icon.style.color = '#cbd5e1';
        }
    }
</script>
@endsection