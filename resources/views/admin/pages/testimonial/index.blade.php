@extends('admin.layouts.main')
@section('title', 'Testimonials')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
<style>
    .note-editor.note-frame {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        background: #f8fafc;
    }

    .dark .note-editor.note-frame {
        background: #1e293b;
        color: white;
    }

    .note-toolbar {
        background: #f1f5f9 !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 8px 12px !important;
        border-radius: 1rem 1rem 0 0 !important;
    }

    .dark .note-toolbar {
        background: #0f172a !important;
        border-bottom: 1px solid #1e293b !important;
    }

    .note-editable {
        min-height: 200px !important;
        padding: 12px 16px !important;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8fafc !important;
    }

    .dark .note-editable {
        background: #1e293b !important;
        color: #e2e8f0 !important;
    }

    .note-statusbar {
        background: #f1f5f9 !important;
        border-top: 1px solid #e2e8f0 !important;
    }

    .dark .note-statusbar {
        background: #0f172a !important;
        border-top: 1px solid #1e293b !important;
    }

    .note-popover,
    .note-dropdown-menu {
        z-index: 99999 !important;
    }
</style>
@endpush
@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Testimonials</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">Manage student testimonials</p>
    </div>
    <div class="mt-6 md:mt-0">
        <button onclick="openModal('create-testimonial-modal')"
            class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 hover:scale-[1.02] transition-all group">
            <i data-lucide="plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Add Testimonial
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
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">#</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Image</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Name & Designation</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Description Preview</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($testimonials as $testimonial)
                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-8 py-5 text-sm font-bold text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-8 py-5">
                        @if($testimonial->image)
                        <img src="{{ asset($testimonial->image) }}" class="w-12 h-12 rounded-xl object-cover" alt="Image">
                        @else
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                            <i data-lucide="image" class="w-5 h-5"></i>
                        </div>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $testimonial->name }}</span>
                            <span class="text-[12px] font-bold text-slate-400">{{ $testimonial->designation }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 max-w-xs">
                        <div class="text-sm text-slate-500 dark:text-slate-400 max-w-xs line-clamp-2">
                            {!! $testimonial->description !!}
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button
                                onclick="editTestimonial({{ $testimonial->id }}, '{{ addslashes($testimonial->name) }}', '{{ addslashes($testimonial->designation) }}', {{ json_encode($testimonial->description) }})"
                                class="p-2 text-slate-400 hover:text-[#0062ff] hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all"
                                title="Edit">
                                <i data-lucide="edit-3" class="w-4.5 h-4.5"></i>
                            </button>
                            <form action="{{ route('admin.testimonial.destroy', $testimonial->id) }}" method="POST"
                                onsubmit="return confirm('Delete this testimonial?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all"
                                    title="Delete">
                                    <i data-lucide="trash-2" class="w-4.5 h-4.5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <i data-lucide="message-square" class="w-10 h-10 opacity-30"></i>
                            <p class="text-sm font-bold">No testimonials added yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="create-testimonial-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('create-testimonial-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add Testimonial</h3>
            </div>
            <button type="button" onclick="closeModal('create-testimonial-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-7">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Name</label>
                    <input type="text" name="name" required placeholder="e.g. John Doe"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Designation</label>
                    <input type="text" name="designation" required placeholder="e.g. Student"
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Description</label>
                <textarea name="description" id="create-summernote" class="w-full rounded-2xl"></textarea>
            </div>

            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('create-testimonial-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Add Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

<div id="edit-testimonial-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('edit-testimonial-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Testimonial</h3>
            </div>
            <button type="button" onclick="closeModal('edit-testimonial-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="edit-testimonial-form" method="POST" enctype="multipart/form-data" class="p-8 space-y-7">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Name</label>
                    <input type="text" name="name" id="edit-name" required
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Designation</label>
                    <input type="text" name="designation" id="edit-designation" required
                        class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Image (Leave blank to keep current)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
            </div>
            <div class="mb-4">
                @if(isset($testimonial) && $testimonial->image)
                <div class="mt-2">
                    <p class="text-xs text-gray-500 mb-1">Current Image:</p>
                    <img src="{{ asset($testimonial->image) }}"
                        class="w-24 h-24 object-cover rounded-md border">
                </div>
                @endif
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Description</label>
                <textarea name="description" id="edit-summernote" class="w-full rounded-2xl"></textarea>
            </div>

            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('edit-testimonial-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Update Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    const summernoteConfig = {
        height: 280,
        focus: false,
        placeholder: 'Write description here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        fontNames: ['Arial', 'Courier New', 'Georgia', 'Helvetica', 'Plus Jakarta Sans', 'Times New Roman', 'Verdana'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48', '64'],
    };

    $(document).ready(function() {
        $('#create-summernote').summernote(summernoteConfig);
        $('#edit-summernote').summernote(summernoteConfig);
    });

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editTestimonial(id, name, designation, description) {
        const form = document.getElementById('edit-testimonial-form');
        form.action = `/admin/testimonial/${id}`;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-designation').value = designation;
        $('#edit-summernote').summernote('code', description);
        openModal('edit-testimonial-modal');
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
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
@endpush