@extends('layouts.client')

@section('title', $course->name . ' - Course Detail')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-3">
            
            <div class="lg:col-span-2 space-y-10">
                <div class="rounded-[2rem] overflow-hidden shadow-xl">
                    <img src="{{ $course->image }}" alt="{{ $course->name }}" class="w-full h-[420px] object-cover">
                </div>

                <div class="bg-white rounded-[2rem] p-10 shadow-lg">
                    <h2 class="text-3xl font-black text-slate-900 mb-8">Course Curriculum & Overview</h2>
                    
                    <div class="prose prose-slate max-w-none prose-headings:font-bold prose-p:leading-relaxed">
                        {{-- Replace the dummy text with {!! $course->content !!} when ready --}}
                        <h3>Introduction to the Course</h3>
                        <p>Welcome to <strong>{{ $course->name }}</strong>. In this comprehensive program, we dive deep into industry-standard practices. This section is rendered to support <em>rich text formatting</em> directly from your editor.</p>
                        
                        <ul>
                            <li>Advanced methodology and workflow optimization.</li>
                            <li>Integration with modern toolsets and frameworks.</li>
                            <li>Real-world case studies and problem-solving scenarios.</li>
                        </ul>

                        <blockquote>
                            "The best way to predict the future is to create it." - Learn by doing through our interactive modules.
                        </blockquote>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-[2rem] bg-white p-8 shadow-lg">
                    <div class="mb-6">
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Course Price</p>
                        <p class="text-3xl font-black text-slate-900 mt-3">{{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}</p>
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