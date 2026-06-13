@extends('layouts.student')
@section('title', 'Free Video Library')
@section('content')
<div class="mb-10 text-center max-w-2xl mx-auto">
    <h3 class="text-3xl font-bold text-slate-800 mb-3">Expert Masterclasses</h3>
    <p class="text-slate-500">Access our collection of free educational videos available to all registered students. Start learning today!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($videos as $video)
    <div class="group h-full flex flex-col">
        <div class="card !p-0 overflow-hidden flex-1 shadow-sm hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
            <div class="relative aspect-video bg-slate-900 overflow-hidden">
                @php
                    $videoId = '';
                    if (str_contains($video->video_url, 'youtube.com/watch?v=')) {
                        $videoId = explode('v=', $video->video_url)[1];
                        $videoId = explode('&', $videoId)[0];
                    } elseif (str_contains($video->video_url, 'youtu.be/')) {
                        $videoId = explode('youtu.be/', $video->video_url)[1];
                        $videoId = explode('?', $videoId)[0];
                    }
                @endphp
                
                @if($videoId)
                <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center text-slate-500">
                    <i data-lucide="video" class="w-12 h-12"></i>
                </div>
                @endif

                <div class="absolute inset-0 flex items-center justify-center">
                    <a href="{{ $video->video_url }}" target="_blank" class="w-16 h-16 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-600 shadow-2xl group-hover:scale-110 transition-transform">
                        <i data-lucide="play" class="w-8 h-8 fill-current"></i>
                    </a>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-lg">Free Content</span>
                </div>
            </div>
            <div class="p-6 flex flex-col h-full">
                <h4 class="font-bold text-slate-800 text-lg mb-4 line-clamp-2 leading-tight">{{ $video->title }}</h4>
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50">
                    <div class="flex items-center gap-2 text-slate-500">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span class="text-xs font-bold">{{ $video->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ $video->video_url }}" target="_blank" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:underline">Watch Now</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-100">
        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i data-lucide="video-off" class="w-10 h-10"></i>
        </div>
        <h4 class="text-xl font-bold text-slate-800 mb-2">No free videos available</h4>
        <p class="text-slate-500">Check back later for new expert content.</p>
    </div>
    @endforelse
</div>
@endsection
