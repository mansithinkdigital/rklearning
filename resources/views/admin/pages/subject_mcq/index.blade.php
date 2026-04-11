@extends('admin.layouts.main')

@section('title', 'Manage MCQs for ' . $subject->name)

@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">
            MCQs for: {{ $subject->name }}
        </h1>
        <p class="text-sm font-bold text-slate-400 dark:text-slate-500">
            Course: {{ $subject->course->name }}
        </p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('admin.subject.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
            &larr; Back to Subjects
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center gap-3">
    <i data-lucide="check-circle" class="w-5 h-5"></i>
    <span class="text-sm font-bold">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl">
    <div class="flex items-center gap-3 mb-2">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold">Please correct the following errors:</span>
    </div>
    <ul class="list-disc ml-8 text-xs font-bold">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Add Multiple MCQs Form -->
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden mb-12">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
        <h2 class="text-xl font-black text-slate-900 dark:text-white">Add New MCQs</h2>
        <button type="button" onclick="addMcqCard()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-200 dark:shadow-none flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Question Block
        </button>
    </div>

    <form action="{{ route('admin.subject.mcqs.storeMultiple', $subject->id) }}" method="POST" id="mcqs-form" class="p-8 group-form">
        @csrf
        <div id="mcqs-container" class="space-y-8">
            <!-- MCQ Blocks will be inserted here -->
        </div>

        <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800 hidden" id="submit-section">
            <button type="submit" onclick="return validateForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all w-full flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Save All Questions
            </button>
        </div>
    </form>
</div>

<!-- Existing MCQs Section -->
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800">
        <h2 class="text-xl font-black text-slate-900 dark:text-white">Existing MCQs ({{ $mcqs->count() }})</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/30">
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Question</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Options (Correct in Green)</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($mcqs as $mcq)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10">
                    <td class="px-8 py-5 w-1/2">
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $mcq->question }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <ul class="space-y-1">
                            @foreach($mcq->options as $idx => $opt)
                            <li class="text-xs font-bold flex items-center gap-2 {{ $opt === $mcq->answer ? 'text-emerald-600' : 'text-slate-500' }}">
                                <span class="w-4 h-4 flex items-center justify-center rounded-full text-[9px] {{ $opt === $mcq->answer ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">{{ chr(65 + $idx) }}</span>
                                {{ $opt }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-8 py-5 text-right w-32">
                        <form action="{{ route('admin.course-mcq.destroy', $mcq->id) }}" method="POST" onsubmit="return confirm('Delete this MCQ?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-8 py-12 text-center">
                        <p class="text-sm font-bold text-slate-400">No MCQs found for this subject.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let blockIndex = 0;

    function addMcqCard() {
        const container = document.getElementById('mcqs-container');
        const submitSection = document.getElementById('submit-section');
        
        const idx = blockIndex++;
        const card = document.createElement('div');
        card.className = "p-6 border border-slate-200 dark:border-slate-700 rounded-2xl relative bg-slate-50/50 dark:bg-slate-800/20";
        card.id = `mcq-block-${idx}`;
        
        card.innerHTML = `
            <div class="absolute top-4 right-4">
                <button type="button" onclick="removeMcqCard(${idx})" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors">
                    <i data-lucide="trash" class="w-4 h-4"></i>
                </button>
            </div>
            
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Question #${idx + 1}</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Question Title *</label>
                    <input type="text" name="mcqs[${idx}][question]" required placeholder="Enter question"
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Options & Correct Answer *</label>
                    <p class="text-[10px] mb-3 text-slate-400">Select the radio button next to the correct answer.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="options-container-${idx}">
                        ${[0,1,2,3].map(optIdx => `
                            <div class="flex items-center gap-3 p-2 bg-white border border-slate-200 rounded-xl focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                                <input type="radio" name="_correct_${idx}" value="${optIdx}" required class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 focus:ring-blue-500">
                                <span class="text-xs font-black text-slate-400 w-4">${String.fromCharCode(65 + optIdx)}</span>
                                <input type="text" name="mcqs[${idx}][options][]" required placeholder="Option ${String.fromCharCode(65 + optIdx)}"
                                    class="flex-1 bg-transparent text-sm font-bold text-slate-800 outline-none">
                            </div>
                        `).join('')}
                    </div>
                </div>
                <!-- Hidden input to store proper answer string before submit -->
                <input type="hidden" name="mcqs[${idx}][answer]" id="answer-${idx}">
            </div>
        `;
        
        container.appendChild(card);
        submitSection.classList.remove('hidden');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function removeMcqCard(idx) {
        const card = document.getElementById(`mcq-block-${idx}`);
        if(card) {
            card.remove();
        }
        if(document.getElementById('mcqs-container').children.length === 0) {
            document.getElementById('submit-section').classList.add('hidden');
        }
    }

    function validateForm() {
        const container = document.getElementById('mcqs-container');
        const blocks = container.children;
        if(blocks.length === 0) return false;

        for (let i = 0; i < blocks.length; i++) {
            const block = blocks[i];
            const idxMatch = block.id.match(/\d+/);
            if(!idxMatch) continue;
            const idx = idxMatch[0];

            const radios = block.querySelectorAll(`input[name="_correct_${idx}"]`);
            let checkedRadio = null;
            radios.forEach(r => { if(r.checked) checkedRadio = r; });

            if(!checkedRadio) {
                alert(`Please select a correct answer for block ${Array.from(blocks).indexOf(block) + 1}`);
                return false;
            }

            const optIndex = parseInt(checkedRadio.value);
            const optInputs = block.querySelectorAll(`input[name="mcqs[${idx}][options][]"]`);
            const correctText = optInputs[optIndex].value.trim();
            
            if(!correctText) {
                alert(`The correct option for block ${Array.from(blocks).indexOf(block) + 1} cannot be empty!`);
                return false;
            }

            document.getElementById(`answer-${idx}`).value = correctText;
        }

        return true;
    }

    // Auto add first block if no MCQs
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
        @if($mcqs->count() == 0)
            addMcqCard();
        @endif
    });
</script>
@endsection
