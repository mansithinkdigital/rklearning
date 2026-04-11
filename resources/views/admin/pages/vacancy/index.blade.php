@extends('admin.layouts.main')
@section('title', 'Vacancies')

@push('styles')
{{-- Summernote CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
<style>
    /* Summernote modal overrides to play nicely with our design */
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

    /* Fix z-index for summernote dropdowns inside modals */
    .note-popover,
    .note-dropdown-menu {
        z-index: 99999 !important;
    }

    .modal-body .note-editor {
        border-radius: 1rem;
    }
</style>
@endpush

@section('content')

<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Vacancies</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">Post and manage job openings</p>
    </div>
    <div class="mt-6 md:mt-0">
        <button onclick="openModal('create-vacancy-modal')"
            class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 hover:scale-[1.02] transition-all group">
            <i data-lucide="plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Post Vacancy
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

{{-- Vacancies Table --}}
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-[#f1f5f9] dark:border-slate-800 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50 dark:border-slate-800">
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">#</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Title</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Experience</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Description Preview</th>
                    <th class="px-8 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($vacancies as $vacancy)
                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-8 py-5 text-sm font-bold text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-500 shrink-0">
                                <i data-lucide="briefcase" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $vacancy->title }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-lg text-xs font-black">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            {{ $vacancy->experience }}
                        </span>
                    </td>
                    <td class="px-8 py-5 max-w-xs">
                        <div class="text-sm text-slate-500 dark:text-slate-400 max-w-xs line-clamp-2">
                            {!! $vacancy->description !!}
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button
                                onclick="editVacancy({{ $vacancy->id }}, '{{ addslashes($vacancy->title) }}', '{{ addslashes($vacancy->experience) }}', {{ json_encode($vacancy->description) }})"
                                class="p-2 text-slate-400 hover:text-[#0062ff] hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all"
                                title="Edit">
                                <i data-lucide="edit-3" class="w-4.5 h-4.5"></i>
                            </button>
                            <form action="{{ route('admin.vacancy.destroy', $vacancy->id) }}" method="POST"
                                onsubmit="return confirm('Delete this vacancy?')">
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
                            <i data-lucide="briefcase" class="w-10 h-10 opacity-30"></i>
                            <p class="text-sm font-bold">No vacancies posted yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- ==================== CREATE MODAL ==================== --}}
<div id="create-vacancy-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('create-vacancy-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">

        {{-- Header --}}
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Post New Vacancy</h3>
            </div>
            <button onclick="closeModal('create-vacancy-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.vacancy.store') }}" method="POST" class="p-8 space-y-7">
            @csrf

            {{-- Title --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Job Title</label>
                <input type="text" name="title" required placeholder="e.g. Senior Maths Teacher"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
            </div>

            {{-- Experience --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Experience Required</label>
                <input type="text" name="experience" required placeholder="e.g. 3+ Years"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
            </div>

            {{-- Description - Summernote --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Job Description</label>
                <textarea name="description" id="create-summernote" class="w-full rounded-2xl"></textarea>
            </div>

            {{-- Actions --}}
            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('create-vacancy-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Post Vacancy
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ==================== EDIT MODAL ==================== --}}
<div id="edit-vacancy-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('edit-vacancy-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">

        {{-- Header --}}
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Vacancy</h3>
            </div>
            <button onclick="closeModal('edit-vacancy-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Form --}}
        <form id="edit-vacancy-form" method="POST" class="p-8 space-y-7">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Job Title</label>
                <input type="text" name="title" id="edit-title" required
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
            </div>

            {{-- Experience --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Experience Required</label>
                <input type="text" name="experience" id="edit-experience" required
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
            </div>

            {{-- Description - Summernote --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Job Description</label>
                <textarea name="description" id="edit-summernote" class="w-full rounded-2xl"></textarea>
            </div>

            {{-- Actions --}}
            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('edit-vacancy-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Update Vacancy
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
{{-- jQuery (required for Summernote) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- Summernote JS --}}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
    // ── Summernote config shared between both editors ──────────────────
    const summernoteConfig = {
        height: 280,
        focus: false,
        placeholder: 'Write detailed job description here...',
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
        // Init Summernote for CREATE modal
        $('#create-summernote').summernote(summernoteConfig);

        // Init Summernote for EDIT modal
        $('#edit-summernote').summernote(summernoteConfig);
    });

    // ── Modal helpers ──────────────────────────────────────────────────
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // ── Populate edit modal ────────────────────────────────────────────
    function editVacancy(id, title, experience, description) {
        const form = document.getElementById('edit-vacancy-form');
        form.action = `/admin/vacancy/${id}`;

        document.getElementById('edit-title').value = title;
        document.getElementById('edit-experience').value = experience;

        // Set Summernote HTML content
        $('#edit-summernote').summernote('code', description);

        openModal('edit-vacancy-modal');
    }

    // ── Auto-dismiss alerts ────────────────────────────────────────────
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