@extends('layouts.client')

@section('title', $course->name . ' - RK Learning Hub')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-3">
            <!-- Left Column: Course Details -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Course Hero Card -->
                <div class="rounded-[2.5rem] overflow-hidden shadow-2xl relative group">
                    <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" class="w-full h-[480px] object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-60"></div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-10 shadow-lg border border-slate-100">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Course Curriculum</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($course->subjects as $subject)
                            <!-- Subject Accordion -->
                            <div class="rounded-3xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                                <button onclick="toggleCurriculum({{ $subject->id }})" class="w-full px-8 py-6 flex items-center justify-between hover:bg-white transition-all text-left group">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                                            <i class="fa fa-book-open"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Subject Module</p>
                                            <h4 class="text-lg font-black text-slate-800 tracking-tight uppercase">{{ $subject->name }}</h4>
                                        </div>
                                    </div>
                                    <i id="icon-subject-{{ $subject->id }}" class="fa fa-chevron-down text-slate-300 transition-transform"></i>
                                </button>

                                <div id="subject-{{ $subject->id }}" class="hidden px-6 pb-6 animate-in slide-in-from-top-2 duration-300">
                                    @foreach($subject->units as $unit)
                                        <div class="mt-4 p-6 bg-white rounded-2xl border border-slate-100">
                                            <div class="flex items-center gap-3 mb-4">
                                                <i class="fa fa-layer-group text-blue-500 text-sm"></i>
                                                <span class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">{{ $unit->name }}</span>
                                            </div>
                                            
                                            <ul class="space-y-3">
                                                @foreach($unit->topics as $topic)
                                                <li class="flex items-center gap-3 text-sm font-medium text-slate-600 pl-2">
                                                    <div class="w-1 h-1 rounded-full bg-blue-400"></div>
                                                    {{ $topic->name }}
                                                </li>
                                                @endforeach
                                            </ul>

                                            @if($unit->paidVideos->count() > 0 || $unit->freePdfs->count() > 0)
                                            <div class="mt-6 pt-4 border-t border-slate-50 flex flex-wrap gap-2">
                                                @foreach($unit->paidVideos as $video)
                                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-lg uppercase tracking-tight">
                                                        <i class="fa fa-play mr-1"></i> Video Class
                                                    </span>
                                                @endforeach
                                                @foreach($unit->freePdfs as $pdf)
                                                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-lg uppercase tracking-tight">
                                                        <i class="fa fa-file-pdf mr-1"></i> PDF Notes
                                                    </span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                <i class="fa fa-layer-group text-slate-300 text-5xl mb-4"></i>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Curriculum under optimization</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-16 pt-16 border-t border-slate-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Key Learning outcomes</h2>
                        </div>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium bg-slate-50 rounded-3xl p-8 border border-slate-100">
                            {!! $course->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <aside class="space-y-8">
                <div class="rounded-[2.5rem] bg-white p-10 shadow-2xl border border-slate-100 sticky top-10">
                    <div class="mb-8">
                        <p class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Total investment</p>
                        <p class="text-5xl font-black text-slate-900 leading-none">
                            @if($course->price > 0)
                                <span class="text-lg font-bold align-top mt-1 inline-block -mr-1">₹</span> {{ number_format($course->price) }}
                            @else
                                FREE
                            @endif
                        </p>
                    </div>

                    <div class="space-y-4 mb-10">
                        @auth
                            @if($hasPurchased)
                                <a href="{{ route('student.learning', $course->id) }}" class="w-full flex items-center justify-center gap-3 py-5 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-200">
                                    <i class="fa fa-play"></i> Access Course Content
                                </a>
                            @else
                                <a href="{{ route('student.courses.checkout', $course->id) }}" class="w-full flex items-center justify-center gap-3 py-5 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200">
                                    Enroll in Course Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('student.login') }}" class="w-full flex items-center justify-center gap-3 py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-200">
                                Sign In to Enroll
                            </a>
                        @endauth
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">Course Highlights</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600"><i class="fa fa-book text-sm"></i></div>
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Global Modules</span>
                                </div>
                                <span class="text-sm font-black text-slate-800">{{ $course->subjects->count() }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600"><i class="fa fa-users text-sm"></i></div>
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Active Learners</span>
                                </div>
                                <span class="text-sm font-black text-slate-800">{{ $course->students->count() }}+</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600"><i class="fa fa-certificate text-sm"></i></div>
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Certification</span>
                                </div>
                                <span class="text-sm font-black text-slate-800">ISO 9001</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Assistance Card -->
                <div class="rounded-[2rem] bg-gradient-to-br from-slate-900 to-slate-800 p-8 shadow-xl text-white">
                    <h4 class="text-lg font-black mb-2 uppercase italic tracking-tighter">Need Assistance?</h4>
                    <p class="text-slate-400 text-xs font-bold leading-relaxed mb-6">Our academic counselors are available to guide your learning path.</p>
                    <a href="{{ route('contact') }}" class="flex items-center justify-center gap-2 py-4 bg-white/10 hover:bg-white/20 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                        Support Center
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>

<script>
    function toggleCurriculum(id) {
        const el = document.getElementById(`subject-${id}`);
        const icon = document.getElementById(`icon-subject-${id}`);
        if(el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            el.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endsection