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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @php
        $mockCourses = [
            ['id' => 1, 'title' => 'Professional Tally Prime', 'tag' => 'Accounting', 'progress' => 65, 'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=2022'],
            ['id' => 2, 'title' => 'Advanced Share Market', 'tag' => 'Finance', 'progress' => 20, 'image' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?q=80&w=2070'],
            ['id' => 3, 'title' => 'Graphic Design Masterclass', 'tag' => 'Design', 'progress' => 0, 'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=2071']
        ];
    @endphp

    @foreach($mockCourses as $course)
    <div class="group">
        <div class="card !p-0 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
            <div class="relative aspect-video">
                <img src="{{ $course['image'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center">
                    <a href="{{ route('student.learning', $course['id']) }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 scale-0 group-hover:scale-100 transition-transform duration-300 shadow-xl">
                        <i data-lucide="play" class="w-6 h-6 fill-current"></i>
                    </a>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-bold text-slate-800 uppercase tracking-wider">{{ $course['tag'] }}</span>
                </div>
            </div>
            
            <div class="p-6">
                <h4 class="font-bold text-slate-800 mb-4 group-hover:text-blue-600 transition truncate">{{ $course['title'] }}</h4>
                
                <div class="flex items-center justify-between text-xs font-bold mb-2">
                    <span class="{{ $course['progress'] > 0 ? 'text-blue-600' : 'text-slate-400' }}">{{ $course['progress'] }}% Completed</span>
                    <span class="text-slate-400">Lessons</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full">
                    <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $course['progress'] }}%"></div>
                </div>
                
                <div class="mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
                    <div class="flex -space-x-2">
                        <img class="w-7 h-7 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Trainer&background=random">
                    </div>
                    @if($course['progress'] == 100)
                        <span class="text-emerald-500 text-xs font-bold flex items-center"><i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Completed</span>
                    @else
                        <a href="{{ route('student.learning', $course['id']) }}" class="text-xs font-bold text-slate-500 hover:text-blue-600">Continue &rarr;</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
