@extends('layouts.client')

@section('title', $course->name . ' - Course Detail')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-10">
                <div class="rounded-[2rem] overflow-hidden shadow-xl">
<<<<<<< Updated upstream
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
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $video->title }}</h4>
                                    <p class="text-xs text-slate-400">Unit: {{ $video->unit }}</p>
=======
                    <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" class="w-full h-[420px] object-cover">
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

                                <div id="subject-{{ $subject->id }}" class="hidden px-6 pb-6">
                                    @foreach($subject->units as $unit)
                                        <div class="mt-4 p-6 bg-white rounded-2xl border border-slate-100">
                                            <div class="flex items-center gap-3 mb-4">
                                                <i class="fa fa-layer-group text-blue-500 text-sm"></i>
                                                <span class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">{{ $unit->name }}</span>
                                            </div>
                                            
                                            <!-- Topics -->
                                            <ul class="space-y-3">
                                                @foreach($unit->topics as $topic)
                                                <li class="flex items-center gap-3 text-sm font-medium text-slate-600 pl-2">
                                                    <i class="fa fa-circle text-[6px] text-blue-400"></i>
                                                    {{ $topic->name }}
                                                </li>
                                                @endforeach
                                            </ul>

                                            @if($unit->paidVideos->count() > 0 || $unit->freePdfs->count() > 0)
                                            <div class="mt-6 pt-4 border-t border-slate-50 flex flex-wrap gap-2">
                                                @foreach($unit->paidVideos as $video)
                                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-lg uppercase tracking-tight">
                                                        <i class="fa fa-play mr-1"></i> Class Video
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
>>>>>>> Stashed changes
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($hasPurchased)
                                @if($video->pdf)
                                <a href="{{ asset($video->pdf) }}" download class="flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-500 text-white text-xs font-bold hover:bg-emerald-600 transition">
                                    <i class="fa fa-download"></i> PDF
                                </a>
                                @endif
                                <a href="{{ route('student.learning', $course->id) }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition">
                                    <i class="fa fa-play"></i> Watch
                                </a>
                                @else
                                <span class="text-slate-400 text-xs font-medium italic"><i class="fa fa-lock mr-1"></i> Locked</span>
                                @endif
                            </div>
                        </div>
                        @empty
<<<<<<< Updated upstream
                        <div class="text-left">
                            <p class="text-slate-400"> {{ $course->description }}</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="mt-10 prose prose-slate max-w-none prose-headings:font-bold prose-p:leading-relaxed">
                        <h2 class="text-2xl font-black text-slate-900 mb-2">Course Description :</h2>
                        {!! $course->long_description !!}
=======
                            <div class="text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                <i class="fa fa-layer-group text-slate-300 text-5xl mb-4"></i>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Curriculum under optimization</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-16 pt-16 border-t border-slate-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Description</h2>
                        </div>
                        <div class="prose prose-slate max-w-none text-slate-500 leading-relaxed font-medium">
                            {!! $course->description !!}
                        </div>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>

<<<<<<< Updated upstream
            <aside class="space-y-6">
                <div class="rounded-[2rem] bg-white p-8 shadow-lg">
                    <div class="mb-6">
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Course Price</p>
                        <p class="text-3xl font-black text-slate-900 mt-3">{{ $course->price > 0 ? '₹'.number_format($course->price, 2) : 'Free' }}</p>
                    </div>
                    @auth
                    @if($hasPurchased)
                    <a href="{{ route('student.learning', $course->id) }}" class="btn-primary w-full inline-flex items-center justify-center py-3 text-sm font-bold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">Start Learning</a>
                    @else
                    <form action="{{ route('student.courses.purchase', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary w-full inline-flex items-center justify-center py-3 text-sm font-bold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">Purchase Course</button>
                    </form>
                    @endif
                    @else
                    <a href="{{ route('student.login') }}" class="btn-primary w-full inline-flex items-center justify-center py-3 text-sm font-bold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">Login to Purchase</a>
                    @endauth
                </div>

                <div class="rounded-[2rem] bg-white p-8 shadow-lg">
                    <div class="mb-8">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa fa-info-circle text-blue-600"></i> Course Details
                        </h3>
                        <ul class="space-y-3 text-sm text-slate-500">
                            <li class="flex justify-between border-b border-slate-50 pb-2">
                                <strong class="text-slate-800">Status:</strong>
                                <span>{{ $course->status }}</span>
                            </li>
                            <li class="flex justify-between border-b border-slate-50 pb-2">
                                <strong class="text-slate-800">Lessons:</strong>
                                <span>{{ $course->subjects->count() }} Modules</span>
                            </li>
                            <li class="flex justify-between border-b border-slate-50 pb-2">
                                <strong class="text-slate-800">Enrolled:</strong>
                                <span>{{ $course->students->count() }} Students</span>
                            </li>
                        </ul>
=======
            <aside class="space-y-8">
                <div class="rounded-[2.5rem] bg-white p-10 shadow-xl border border-slate-100 sticky top-10">
                    <div class="mb-8">
                        <p class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Total investment</p>
                        <p class="text-4xl font-black text-slate-900 leading-none">
                            @if($course->price > 0)
                                <span class="text-sm font-bold align-top">INR</span> {{ number_format($course->price) }}
                            @else
                                FREE
                            @endif
                        </p>
>>>>>>> Stashed changes
                    </div>

                    <div class="space-y-4 mb-10">
                        @auth
                            @if($hasPurchased)
                                <a href="{{ route('student.learning', $course->id) }}" class="w-full flex items-center justify-center gap-3 py-5 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-200">
                                    <i class="fa fa-play"></i> Start Learning
                                </a>
                            @else
                                <form action="{{ route('student.courses.purchase', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-3 py-5 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200">
                                        Purchase Membership
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('student.login') }}" class="w-full flex items-center justify-center gap-3 py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-200">
                                Login to Enroll
                            </a>
                        @endauth
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">Key Metrics</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600"><i class="fa fa-book text-xs"></i></div>
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-tight">Modules</span>
                                </div>
                                <span class="text-sm font-black text-slate-800">{{ $course->subjects->count() }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600"><i class="fa fa-users text-xs"></i></div>
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-tight">Learners</span>
                                </div>
                                <span class="text-sm font-black text-slate-800">{{ $course->students->count() }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600"><i class="fa fa-certificate text-xs"></i></div>
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-tight">Accreditation</span>
                                </div>
                                <span class="text-sm font-black text-slate-800">ISO Cert</span>
                            </li>
                        </ul>
                    </div>
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