@extends('admin.layouts.main')
@section('title', 'Gallery')
@section('content')

<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Gallery</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">Manage and upload images to the gallery</p>
    </div>
    <div class="flex items-center gap-4 mt-6 md:mt-0">
        <button onclick="openModal('create-gallery-modal')"
            class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] dark:bg-blue-700 rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 hover:scale-[1.02] transition-all group">
            <i data-lucide="image-plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Upload Image
        </button>
    </div>
</div>

@if(session('success'))
<div id="success-alert"
    class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 transition-opacity duration-500">
    <i data-lucide="check-circle" class="w-5 h-5"></i>
    <span class="text-sm font-bold">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div id="error-alert"
    class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl flex items-center gap-3 transition-opacity duration-500">
    <i data-lucide="x-circle" class="w-5 h-5"></i>
    <span class="text-sm font-bold">{{ session('error') }}</span>
</div>
@endif

{{-- Gallery Image Grid --}}
@if($galleries->isEmpty())
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-[#f1f5f9] dark:border-slate-800 shadow-sm py-24 flex flex-col items-center justify-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-400">
        <i data-lucide="image-off" class="w-8 h-8"></i>
    </div>
    <p class="text-slate-400 font-bold text-sm">No images uploaded yet.</p>
    <button onclick="openModal('create-gallery-modal')"
        class="mt-2 px-6 py-3 bg-[#0062ff] text-white rounded-xl text-xs font-black uppercase tracking-widest shadow hover:scale-105 transition-all">
        Upload First Image
    </button>
</div>
@else
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
    @foreach($galleries as $gallery)
    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300">
        {{-- Image --}}
        <div class="aspect-square overflow-hidden bg-slate-50 dark:bg-slate-800">
            <img
                src="{{ asset('admin/uploads/galleryimg/' . $gallery->image) }}"
                alt="Gallery Image #{{ $gallery->id }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>

        {{-- Hover overlay with actions --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-3">
            <button
                onclick="openEditModal({{ $gallery->id }}, '{{ asset('admin/uploads/galleryimg/' . $gallery->image) }}')"
                class="flex items-center gap-2 px-4 py-2 bg-white text-slate-800 rounded-xl text-xs font-black uppercase tracking-wider shadow-lg hover:scale-105 transition-all">
                <i data-lucide="edit-3" class="w-3.5 h-4.0"></i>
            </button>
            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
                onsubmit="return confirm('Delete this image? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-xl text-xs font-black uppercase tracking-wider shadow-lg hover:scale-105 transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-4.0"></i>
                </button>
            </form>
        </div>

        {{-- Image ID badge --}}
        <div class="absolute top-2 left-2">
            <span class="text-[9px] font-black bg-white/90 dark:bg-slate-900/90 text-slate-500 px-2 py-1 rounded-full shadow-sm backdrop-blur-sm">#{{ $gallery->id }}</span>
        </div>
    </div>
    @endforeach
</div>
@endif


{{-- ==================== CREATE MODAL ==================== --}}
<div id="create-gallery-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('create-gallery-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <i data-lucide="image-plus" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Upload Image</h3>
            </div>
            <button onclick="closeModal('create-gallery-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            {{-- Drag & Drop Preview Area --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Select Image</label>
                <label for="create-image-input"
                    class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all group">
                    <div id="create-preview-wrapper" class="hidden w-full h-full relative">
                        <img id="create-preview" src="#" alt="Preview" class="w-full h-full object-contain rounded-2xl p-2">
                        <button type="button" onclick="clearCreatePreview(event)"
                            class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-all shadow">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </div>
                    <div id="create-upload-placeholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-blue-500 transition-colors">
                        <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                        <p class="text-sm font-bold">Click or drag image here</p>
                        <p class="text-xs font-medium">JPEG, PNG, JPG, GIF · Max 10MB</p>
                    </div>
                </label>
                <input type="file" name="image" id="create-image-input" accept="image/*" required class="hidden"
                    onchange="previewImage(event, 'create-preview', 'create-preview-wrapper', 'create-upload-placeholder')">
            </div>

            {{-- Actions --}}
            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('create-gallery-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Upload Image
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ==================== EDIT MODAL ==================== --}}
<div id="edit-gallery-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('edit-gallery-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Replace Image</h3>
            </div>
            <button onclick="closeModal('edit-gallery-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Form --}}
        <form id="edit-gallery-form" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Current Image Preview --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Current Image</label>
                <div class="w-full h-36 bg-slate-50 dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700">
                    <img id="edit-current-preview" src="" alt="Current" class="w-full h-full object-contain p-2">
                </div>
            </div>

            {{-- New Image Upload --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Replace With New Image</label>
                <label for="edit-image-input"
                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-all group">
                    <div id="edit-preview-wrapper" class="hidden w-full h-full relative">
                        <img id="edit-new-preview" src="#" alt="New Preview" class="w-full h-full object-contain rounded-2xl p-2">
                        <button type="button" onclick="clearEditPreview(event)"
                            class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-all shadow">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </div>
                    <div id="edit-upload-placeholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-blue-500 transition-colors">
                        <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                        <p class="text-xs font-bold">Click to select a replacement image</p>
                        <p class="text-xs font-medium text-slate-300">Leave blank to keep current image</p>
                    </div>
                </label>
                <input type="file" name="image" id="edit-image-input" accept="image/*" class="hidden"
                    onchange="previewImage(event, 'edit-new-preview', 'edit-preview-wrapper', 'edit-upload-placeholder')">
            </div>

            {{-- Actions --}}
            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('edit-gallery-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Update Image
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

    function openEditModal(id, currentImageUrl) {
        const form = document.getElementById('edit-gallery-form');
        form.action = `/admin/gallery/${id}`;
        // Show current image in the edit modal
        document.getElementById('edit-current-preview').src = currentImageUrl;
        // Reset the new image preview
        clearEditPreviewSilent();
        openModal('edit-gallery-modal');
    }

    function previewImage(event, previewId, wrapperId, placeholderId) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(wrapperId).classList.remove('hidden');
            document.getElementById(placeholderId).classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function clearCreatePreview(event) {
        event.preventDefault();
        event.stopPropagation();
        document.getElementById('create-image-input').value = '';
        document.getElementById('create-preview').src = '#';
        document.getElementById('create-preview-wrapper').classList.add('hidden');
        document.getElementById('create-upload-placeholder').classList.remove('hidden');
    }

    function clearEditPreview(event) {
        event.preventDefault();
        event.stopPropagation();
        clearEditPreviewSilent();
    }

    function clearEditPreviewSilent() {
        document.getElementById('edit-image-input').value = '';
        const preview = document.getElementById('edit-new-preview');
        if (preview) preview.src = '#';
        const wrapper = document.getElementById('edit-preview-wrapper');
        if (wrapper) wrapper.classList.add('hidden');
        const placeholder = document.getElementById('edit-upload-placeholder');
        if (placeholder) placeholder.classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        // Auto-dismiss alerts
        ['success-alert', 'error-alert'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                }, 3000);
            }
        });
    });
</script>
@endsection