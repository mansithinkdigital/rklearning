@extends('layouts.student')
@section('title', 'Free PDF Resources')
@section('content')
<div class="mb-10 text-center max-w-2xl mx-auto">
    <h3 class="text-3xl font-bold text-slate-800 mb-3">Resource Collections</h3>
    <p class="text-slate-500">Download high-quality PDF study materials and resources available to all registered members.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($pdfs as $pdf)
    <div class="group">
        <div class="card bg-white border-slate-100 p-8 flex flex-col items-center text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:border-emerald-500 group-hover:-translate-y-1">
            <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                <i data-lucide="file-text" class="w-10 h-10"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-lg mb-2 line-clamp-1 truncate w-full">{{ $pdf->pdf_name }}</h4>
            <p class="text-sm text-slate-500 mb-6">Course: {{ $pdf->course->name ?? 'Global Resource' }}</p>
            
            <div class="w-full pt-6 border-t border-slate-50 flex items-center justify-between">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $pdf->created_at->format('d M, Y') }}</span>
                <a href="{{ asset($pdf->pdf_file) }}" download class="flex items-center gap-2 text-xs font-black text-emerald-600 uppercase tracking-widest hover:underline">
                    Download <i data-lucide="download" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-100">
        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i data-lucide="file-x" class="w-10 h-10"></i>
        </div>
        <h4 class="text-xl font-bold text-slate-800 mb-2">No PDF materials found</h4>
        <p class="text-slate-500">New learning materials are added regularly. Stay tuned!</p>
    </div>
    @endforelse
</div>
@endsection
