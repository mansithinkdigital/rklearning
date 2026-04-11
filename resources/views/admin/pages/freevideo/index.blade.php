@extends('admin.layouts.main')
@section('title', 'Free Videos')
@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Free Videos</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">Manage free video lessons for students</p>
    </div>
    <div class="flex items-center gap-4 mt-6 md:mt-0">
        <button onclick="openModal('create-video-modal')" class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] dark:bg-blue-700 rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 transition-all group">
            <i data-lucide="plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Add Video
        </button>
    </div>
</div>

@if(session('success'))
<div id="success-alert" class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 transition-opacity duration-500">
    <i data-lucide="check-circle" class="w-5 h-5"></i>
    <span class="text-sm font-bold">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div id="error-alert" class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl flex items-center gap-3 transition-opacity duration-500">
    <i data-lucide="x-circle" class="w-5 h-5"></i>
    <span class="text-sm font-bold">{{ session('error') }}</span>
</div>
@endif

<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-[#f1f5f9] dark:border-slate-800 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50 dark:border-slate-800">
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Title</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Video URL</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($videos as $video)
                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                                <i data-lucide="play" class="w-5 h-5 fill-current"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $video->title }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <a href="{{ $video->video_url }}" target="_blank" class="text-sm font-bold text-blue-500 hover:underline flex items-center gap-2">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            {{ Str::limit($video->video_url, 40) }}
                        </a>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editVideo({{ $video->id }}, '{{ addslashes($video->title) }}', '{{ addslashes($video->video_url) }}')" class="p-2 text-slate-400 hover:text-[#0062ff] transition-colors">
                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                            </button>
                            <form action="{{ route('admin.free-video.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-8 py-12 text-center text-slate-400 font-bold italic">No videos found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div id="create-video-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('create-video-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add New Video</h3>
            <button onclick="closeModal('create-video-modal')" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form action="{{ route('admin.free-video.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Video Title</label>
                <input type="text" name="title" required placeholder="e.g. Introduction to Calculus"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Video URL (YouTube/Vimeo/etc)</label>
                <input type="url" name="video_url" required placeholder="https://youtube.com/..."
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div class="pt-4 flex gap-4">
                <button type="button" onclick="closeModal('create-video-modal')" class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Save Video
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit-video-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('edit-video-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Video</h3>
            <button onclick="closeModal('edit-video-modal')" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="edit-video-form" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Video Title</label>
                <input type="text" name="title" id="edit-title" required
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Video URL</label>
                <input type="url" name="video_url" id="edit-video_url" required
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div class="pt-4 flex gap-4">
                <button type="button" onclick="closeModal('edit-video-modal')" class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Update Video
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editVideo(id, title, url) {
        const form = document.getElementById('edit-video-form');
        form.action = `/admin/free-video/${id}`;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-video_url').value = url;
        openModal('edit-video-modal');
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => {
                    alertBox.remove();
                }, 500); // matches transition duration
            }, 3000); // 3 seconds
        }
    });
</script>
@endsection