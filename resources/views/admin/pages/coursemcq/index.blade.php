@extends('admin.layouts.main')
@section('title', 'Manage MCQs')
@section('content')
<div class="mb-5">
    <a href="{{ route('admin.course-subject.index') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0062ff] text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-lg hover:shadow-blue-500/20 hover:scale-[1.02] transition-all">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Course & Subject
    </a>
</div>

<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
    <div>
        <h1 class="text-[34px] font-black text-[#111827] dark:text-white tracking-tight leading-none mb-3">Manage MCQs</h1>
        <p class="text-[14px] font-bold text-slate-400 dark:text-slate-500">
            Course: <span class="text-blue-500">{{ $courseSubject->course->name }}</span> |
            Subject: <span class="text-blue-500">{{ $courseSubject->subject->name }}</span>
        </p>
    </div>
    <div class="mt-6 md:mt-0">
        <button onclick="openModal('create-mcq-modal')"
            class="flex items-center gap-2 px-6 py-3.5 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl hover:shadow-blue-500/20 hover:scale-[1.02] transition-all group">
            <i data-lucide="plus" class="w-4 h-4 group-hover:scale-125 transition-transform"></i>
            Add MCQ
        </button>
    </div>
</div>

@if(session('success'))
<div id="success-alert" class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3 transition-opacity duration-500">
    <i data-lucide="check-circle" class="w-5 h-5"></i>
    <span class="text-sm font-bold">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-[#f1f5f9] dark:border-slate-800 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50 dark:border-slate-800">
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">#</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Question</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Options</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em]">Correct Answer</th>
                    <th class="px-6 py-6 text-[10px] font-black text-[#94a3b8] uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($mcqs as $mcq)
                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-5 max-w-xs">
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100 leading-snug">
                            {{ $mcq->question }}
                        </p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col gap-1">
                            @foreach($mcq->options as $idx => $opt)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ $opt === $mcq->answer ? 'text-emerald-600' : 'text-slate-500 dark:text-slate-400' }}">
                                <span class="w-4 h-4 rounded-full flex items-center justify-center text-[9px] font-black {{ $opt === $mcq->answer ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 dark:bg-slate-700 text-slate-500' }}">
                                    {{ chr(65 + $idx) }}
                                </span>
                                {{ $opt }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 rounded-lg text-xs font-black">
                            <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                            {{ $mcq->answer }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='editMcq(@json($mcq))'
                                class="p-2 text-slate-400 hover:text-[#0062ff] hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('admin.course-mcq.destroy', $mcq->id) }}" method="POST"
                                onsubmit="return confirm('Delete this MCQ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <i data-lucide="help-circle" class="w-10 h-10 opacity-30"></i>
                            <p class="text-sm font-bold">No MCQs added yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================= CREATE MODAL ========================= --}}
<div id="create-mcq-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('create-mcq-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[92vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add New MCQ</h3>
            </div>
            <button onclick="closeModal('create-mcq-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.course-subject.mcqs.store', $courseSubject->id) }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 space-y-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Step 1 — Question Details</p>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Question Title</label>
                    <input type="text" name="question" required placeholder="Enter question"
                        class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
            </div>

            <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Step 2 — Answer Options</p>
                    <button type="button" onclick="addOption('create-options')"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-black hover:bg-blue-100 transition-colors">
                        <i data-lucide="plus" class="w-3 h-3"></i> Add Option
                    </button>
                </div>
                <div id="create-options" class="space-y-3"></div>
                <p class="text-[10px] font-bold text-slate-400">
                    <i data-lucide="info" class="w-3 h-3 inline"></i>
                    Click the letter button beside an option to mark it as correct.
                </p>
            </div>

            <input type="hidden" name="answer" id="create-answer">

            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('create-mcq-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit" onclick="return setAnswer('create-answer', 'create-options')"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Save MCQ
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= EDIT MODAL ========================= --}}
<div id="edit-mcq-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('edit-mcq-modal')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[92vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl">
        <div class="sticky top-0 z-10 px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 rounded-t-[2.5rem]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit MCQ</h3>
            </div>
            <button onclick="closeModal('edit-mcq-modal')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-mcq-form" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 space-y-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Step 1 — Question Details</p>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Question Title</label>
                    <input type="text" name="question" id="edit-question" required
                        class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all">
                </div>
            </div>

            <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Step 2 — Answer Options</p>
                    <button type="button" onclick="addOption('edit-options')"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-black hover:bg-blue-100 transition-colors">
                        <i data-lucide="plus" class="w-3 h-3"></i> Add Option
                    </button>
                </div>
                <div id="edit-options" class="space-y-3"></div>
                <p class="text-[10px] font-bold text-slate-400">
                    <i data-lucide="info" class="w-3 h-3 inline"></i>
                    Click the letter button beside an option to mark it as correct.
                </p>
            </div>

            <input type="hidden" name="answer" id="edit-answer">

            <div class="flex gap-4 pt-2">
                <button type="button" onclick="closeModal('edit-mcq-modal')"
                    class="flex-1 px-6 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                    Cancel
                </button>
                <button type="submit" onclick="return setAnswer('edit-answer', 'edit-options')"
                    class="flex-1 px-6 py-4 bg-[#0062ff] rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-all">
                    Update MCQ
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

    let optionCounters = {
        'create-options': 0,
        'edit-options': 0
    };

    function addOption(containerId, value = '') {
        const container = document.getElementById(containerId);
        const count = optionCounters[containerId]++;
        const label = String.fromCharCode(65 + count);

        const row = document.createElement('div');
        row.className = 'flex items-center gap-3 group';
        row.dataset.idx = count;
        row.innerHTML = `
            <label class="flex items-center justify-center w-9 h-9 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer hover:border-blue-400 transition-all has-[:checked]:bg-blue-500 has-[:checked]:border-blue-500 shrink-0">
                <input type="radio" name="_correct_option_${containerId}" value="${count}" class="hidden"
                    onchange="highlightCorrect(this, '${containerId}', ${count})">
                <span class="text-[11px] font-black text-slate-500 group-[:has(input:checked)]:text-white select-none correct-label">${label}</span>
            </label>
            <input type="text" name="options[]" value="${value}" required placeholder="Option ${label}"
                class="flex-1 px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all">
            <button type="button" onclick="removeOption(this)" class="p-2 text-slate-300 hover:text-red-400 transition-colors shrink-0">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;
        container.appendChild(row);
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function removeOption(btn) {
        btn.closest('[data-idx]').remove();
    }

    function highlightCorrect(radio, containerId, idx) {
        const container = document.getElementById(containerId);
        container.querySelectorAll('[data-idx]').forEach(r => {
            r.querySelector('input[type=text]').style.borderColor = '';
        });
        const row = container.querySelector(`[data-idx="${idx}"]`);
        if (row) {
            row.querySelector('input[type=text]').style.borderColor = '#22c55e';
        }
    }

    function setAnswer(hiddenId, containerId) {
        const container = document.getElementById(containerId);
        const checked = container.querySelector('input[type=radio]:checked');
        if (!checked) {
            alert('Please select the correct answer.');
            return false;
        }
        const idx = parseInt(checked.value);
        const inputs = container.querySelectorAll('input[type=text][name="options[]"]');
        const answer = inputs[idx] ? inputs[idx].value.trim() : '';
        if (!answer) {
            alert('The correct option cannot be empty.');
            return false;
        }
        document.getElementById(hiddenId).value = answer;
        return true;
    }

    function editMcq(mcq) {
        const form = document.getElementById('edit-mcq-form');
        form.action = `/admin/course-mcq/${mcq.id}`;

        document.getElementById('edit-question').value = mcq.question;
        document.getElementById('edit-answer').value = mcq.answer;

        const container = document.getElementById('edit-options');
        container.innerHTML = '';
        optionCounters['edit-options'] = 0;

        const options = Array.isArray(mcq.options) ? mcq.options : JSON.parse(mcq.options || '[]');
        options.forEach((opt, i) => {
            addOption('edit-options', opt);
            if (opt === mcq.answer) {
                setTimeout(() => {
                    const radios = container.querySelectorAll('input[type=radio]');
                    if (radios[i]) {
                        radios[i].checked = true;
                        highlightCorrect(radios[i], 'edit-options', i);
                    }
                }, 50);
            }
        });

        openModal('edit-mcq-modal');
    }

    document.querySelector('[onclick="openModal(\'create-mcq-modal\')"]').addEventListener('click', () => {
        const container = document.getElementById('create-options');
        if (container.children.length === 0) {
            optionCounters['create-options'] = 0;
            ['Option A', 'Option B', 'Option C', 'Option D'].forEach(p => {
                addOption('create-options');
            });
        }
    });

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