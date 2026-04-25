@extends('layouts.student')
@section('title', 'My Study Material')
@section('content')
<div class="mb-10">
    <h3 class="text-3xl font-bold text-slate-800 mb-3">Course Study Material</h3>
    <p class="text-slate-500">Access exclusive PDF handouts and notes for the courses you have purchased.</p>
</div>
<div class="card !p-0 overflow-hidden shadow-sm border-slate-100 bg-white">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-50 bg-slate-50/30">
                    <th class="px-8 py-5">Material Description</th>
                    <th class="px-8 py-5">Source Course</th>
                    <th class="px-8 py-5">Module / Unit</th>
                    <th class="px-8 py-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($studyMaterials as $material)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-800 block mb-0.5">{{ $material->name }}</span>
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">PDF Handout</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-slate-600">{{ $material->unit->subject->course->name ?? 'Course Material' }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold">
                            {{ $material->unit->name ?? 'General' }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ asset('admin/uploads/material/' . $material->study_material) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition shadow-lg shadow-slate-200">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ asset('admin/uploads/material/' . $material->study_material) }}" download class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                Download
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-200">
                            <i data-lucide="folder-search" class="w-10 h-10"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">No study material found</h4>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto">Purchase a course to unlock its exclusive study materials and PDF handouts.</p>
                        <a href="{{ route('courses') }}" class="mt-6 inline-block text-blue-600 font-bold hover:underline">Browse Courses &rarr;</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
