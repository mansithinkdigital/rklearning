@extends('admin.layouts.main')
@section('title', 'Course Subjects')
@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Course Subjects</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">Manage Course and Subject combinations to add MCQs</p>
    </div>
    <div class="mt-6 md:mt-0">
        <button onclick="openModal('create-cs-modal')"
            class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 hover:scale-[1.02] transition-all group">
            <i data-lucide="plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Add Course & Subject
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
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">#</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Course</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Subject</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($courseSubjects as $cs)
                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-blue-500">{{ $cs->course->name ?? '—' }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-500 dark:text-slate-400">{{ $cs->subject->name ?? '—' }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-start gap-2">
                            <a href="{{ route('admin.course-subject.mcqs.manage', $cs->id) }}"
                                class="flex items-center gap-1.5 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 text-[#0062ff] rounded-xl text-[11px] font-black uppercase tracking-wider hover:bg-[#0062ff] hover:text-white transition-all group/btn">
                                <i data-lucide="layers" class="w-4 h-4"></i> Add/Edit MCQs
                                <span class="ml-1 px-1.5 py-0.5 bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-200 rounded-md text-[10px] group-hover/btn:bg-white/20 group-hover/btn:text-white transition-colors">
                                    {{ $cs->mcqs_count }}
                                </span>
                            </a>
                            <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 mx-1"></div>
                            <button onclick='editCS(@json($cs))'
                                class="p-2 text-slate-400 hover:text-[#0062ff] hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all" title="Edit">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('admin.course-subject.destroy', $cs->id) }}" method="POST"
                                onsubmit="return confirm('Delete this Course & Subject combination?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <i data-lucide="folder-open" class="w-10 h-10 opacity-30"></i>
                            <p class="text-sm font-bold">No course & subject found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================= CREATE MODAL ========================= --}}
<div id="create-cs-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('create-cs-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-xl max-h-[92vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add Course & Subject</h3>
            </div>
            <button onclick="closeModal('create-cs-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('admin.course-subject.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Course</label>
                <select name="course_id" id="create-course" required onchange="loadSubjects(this.value, 'create-subject')"
                    class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Subject</label>
                <select name="subject_id" id="create-subject" required
                    class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                    <option value="">-- Select Course First --</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Marks</label>
                    <input type="number" name="total_marks" required min="0" value="0"
                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pass Marks</label>
                    <input type="number" name="pass_marks" required min="0" value="0"
                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Time Limit (Min)</label>
                    <input type="number" name="time_limit" required min="0" value="0"
                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
            </div>
            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('create-cs-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= EDIT MODAL ========================= --}}
<div id="edit-cs-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('edit-cs-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-xl max-h-[92vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Course & Subject</h3>
            </div>
            <button onclick="closeModal('edit-cs-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="edit-cs-form" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Course</label>
                <select name="course_id" id="edit-course" required onchange="loadSubjects(this.value, 'edit-subject')"
                    class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Subject</label>
                <select name="subject_id" id="edit-subject" required
                    class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                    <option value="">-- Loading... --</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Marks</label>
                    <input type="number" name="total_marks" id="edit-total-marks" required min="0"
                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pass Marks</label>
                    <input type="number" name="pass_marks" id="edit-pass-marks" required min="0"
                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Time Limit (Min)</label>
                    <input type="number" name="time_limit" id="edit-time-limit" required min="0"
                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
            </div>
            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('edit-cs-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Update
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

    function loadSubjects(courseId, targetSelectId, selectedSubjectId = null) {
        const select = document.getElementById(targetSelectId);
        if (!courseId) {
            select.innerHTML = '<option value="">-- Select Course First --</option>';
            return;
        }
        select.innerHTML = '<option value="">Loading...</option>';
        fetch(`/admin/get-subjects/${courseId}`)
            .then(res => res.json())
            .then(subjects => {
                select.innerHTML = '<option value="">-- Select Subject --</option>';
                subjects.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.name;
                    if (selectedSubjectId && s.id == selectedSubjectId) opt.selected = true;
                    select.appendChild(opt);
                });
            })
            .catch(() => {
                select.innerHTML = '<option value="">Error loading subjects</option>';
            });
    }

    function editCS(cs) {
        const form = document.getElementById('edit-cs-form');
        form.action = `/admin/course-subject/${cs.id}`;

        document.getElementById('edit-course').value = cs.course_id;
        loadSubjects(cs.course_id, 'edit-subject', cs.subject_id);

        document.getElementById('edit-total-marks').value = cs.total_marks;
        document.getElementById('edit-pass-marks').value = cs.pass_marks;
        document.getElementById('edit-time-limit').value = cs.time_limit;

        openModal('edit-cs-modal');
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
@endsection