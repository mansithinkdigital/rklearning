@extends('admin.layouts.main')
@section('title', 'Paid Videos')
@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Paid Videos</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">Manage course videos and related materials</p>
    </div>
    <div class="flex items-center gap-4 mt-6 md:mt-0">
        <button onclick="openModal('create-paid-video-modal')" class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] dark:bg-blue-700 rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 transition-all group">
            <i data-lucide="plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Add Paid Video
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
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Course & Title</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Unit</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Material (PDF)</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">
                        Video Link
                    </th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($videos as $video)
                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">{{ $video->course->name }}</span>
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $video->title }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-sm font-bold text-slate-500 dark:text-slate-400">
                        {{ $video->unit }}
                    </td>
                    <td class="px-8 py-6">
                        @if($video->pdf)
                        <a href="{{ asset($video->pdf) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-500 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            View PDF
                        </a>
                        @else
                        <span class="text-xs text-slate-400 italic">No PDF</span>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        @if($video->video_url)
                        <a href="{{ $video->video_url }}" target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-500 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors">
                            <i data-lucide="play-circle" class="w-4 h-4"></i>
                            Watch Video
                        </a>
                        @else
                        <span class="text-xs text-slate-400 italic">No Link</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='editPaidVideo(@json($video))' class="p-2 text-slate-400 hover:text-[#0062ff] transition-colors">
                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                            </button>
                            <form action="{{ route('admin.paid-video.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold italic">No paid videos found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div id="create-paid-video-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('create-paid-video-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add Paid Video</h3>
            <button onclick="closeModal('create-paid-video-modal')" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form action="{{ route('admin.paid-video.store') }}" method="POST" enctype="multipart/form-data" class="p-8 grid grid-cols-2 gap-6">
            @csrf
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Select Course</label>
                <select name="course_id" required class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
                    <option value="">Choose Course</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Title</label>
                <input type="text" name="title" required placeholder="Video Title" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Unit</label>
                <input type="text" name="unit" required placeholder="e.g. Unit 1" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">PDF Material</label>
                <input type="file" name="pdf" required accept="application/pdf" class="w-full px-5 py-3.5 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-xs font-bold text-slate-500 file:hidden cursor-pointer hover:bg-slate-100 transition-colors">
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Video URL (External Link)</label>
                <input type="url" name="video_url" required placeholder="https://..." class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div class="col-span-2 pt-4 flex gap-4">
                <button type="button" onclick="closeModal('create-paid-video-modal')" class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">Cancel</button>
                <button type="submit" class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">Save Paid Video</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit-paid-video-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('edit-paid-video-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Paid Video</h3>
            <button onclick="closeModal('edit-paid-video-modal')" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="edit-paid-video-form" method="POST" enctype="multipart/form-data" class="p-8 grid grid-cols-2 gap-6">
            @csrf
            @method('PUT')
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Select Course</label>
                <select name="course_id" id="edit-course_id" required class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Title</label>
                <input type="text" name="title" id="edit-title" required class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Unit</label>
                <input type="text" name="unit" id="edit-unit" required class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">
                    PDF Material (Optional)
                </label>
                <!-- Upload New -->
                <input type="file" name="pdf" accept="application/pdf"
                    class="w-full px-5 py-3.5 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-xs font-bold text-slate-500 file:hidden cursor-pointer hover:bg-slate-100 transition-colors">
                <!-- Show Existing PDF -->
                <div id="current-pdf" class="mt-2 hidden">
                    <a href="" target="_blank"
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-500 rounded-lg text-xs font-bold">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        View Current PDF
                    </a>
                </div>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Video URL</label>
                <input type="url" name="video_url" id="edit-video_url" required class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>
            <div class="col-span-2 pt-4 flex gap-4">
                <button type="button" onclick="closeModal('edit-paid-video-modal')" class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">Cancel</button>
                <button type="submit" class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">Update Paid Video</button>
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

    function editPaidVideo(video) {
        const form = document.getElementById('edit-paid-video-form');
        form.action = `/admin/paid-video/${video.id}`;

        document.getElementById('edit-course_id').value = video.course_id;
        document.getElementById('edit-title').value = video.title;
        document.getElementById('edit-unit').value = video.unit;
        document.getElementById('edit-video_url').value = video.video_url;

        // ✅ Handle existing PDF
        const pdfDiv = document.getElementById('current-pdf');
        const pdfLink = pdfDiv.querySelector('a');

        if (video.pdf) {
            pdfDiv.classList.remove('hidden');
            pdfLink.href = `/${video.pdf}`;
        } else {
            pdfDiv.classList.add('hidden');
        }

        openModal('edit-paid-video-modal');
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Auto hide alerts
        const alerts = ['success-alert', 'error-alert'];
        alerts.forEach(id => {
            const alertBox = document.getElementById(id);
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            }
        });
    });
</script>
@endsection