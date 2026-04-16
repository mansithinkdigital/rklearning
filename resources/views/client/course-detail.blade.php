@extends('layouts.client')

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
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $video->title }}</h4>
                                    <p class="text-xs text-slate-400">Unit: {{ $video->unit }}</p>
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
                        <div class="text-left">
                            <p class="text-slate-400"> {{ $course->description }}</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="mt-10 prose prose-slate max-w-none prose-headings:font-bold prose-p:leading-relaxed">
                        <h2 class="text-2xl font-black text-slate-900 mb-2">Course Description :</h2>
                        {!! $course->long_description !!}
                    </div>
                </div>
            </div>

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
                    </div>

                    <hr class="border-slate-100 mb-8">

                    <div>
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa fa-star text-amber-500"></i> Course Features
                        </h3>
                        <ul class="space-y-3 text-slate-500 text-sm">
                            <li class="flex items-center gap-3">
                                <i class="fa fa-check-circle text-emerald-500"></i> Expert instructor support
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa fa-check-circle text-emerald-500"></i> Downloadable Pdfs
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa fa-check-circle text-emerald-500"></i> 24/7 learner access
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa fa-check-circle text-emerald-500"></i> Certificate of completion
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection