@extends('admin.layouts.main')

@section('title', 'Unit Management')

@section('content')
<div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <div class="flex items-center gap-2 mb-2">
            @if(isset($subject))
            <a href="{{ route('admin.subject.index', ['course_id' => $subject->course_id]) }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">
                {{ $subject->course->name }}
            </a>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">{{ $subject->name }}</span>
            @endif
        </div>
        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2 uppercase">
            @if(isset($subject))
                {{ $subject->name }} <span class="text-emerald-600">Units</span>
            @else
                UNITS REPOSITORY
            @endif
        </h1>
        <p class="text-sm font-bold text-slate-400 dark:text-slate-500">
            @if(isset($subject))
                Structure your subject curriculum into manageable units
            @else
                Manage academic units and their parent subjects
            @endif
        </p>
    </div>
    @if(isset($subject))
    <a href="{{ route('admin.subject.index', ['course_id' => $subject->course_id]) }}" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-left" class="w-3 h-3"></i>
        Subject Modules
    </a>
    @endif
</div>

<!-- Custom Alert Container -->
<div id="alertContainer" class="hidden mb-6">
    <div id="alertBox" class="p-5 rounded-[1.5rem] flex items-center justify-between border">
        <div class="flex items-center gap-4">
            <div id="alertIcon" class="w-10 h-9 rounded-xl flex items-center justify-center">
                <i data-lucide="info" class="w-5 h-5"></i>
            </div>
            <div>
                <p id="alertTitle" class="text-[11px] font-black uppercase tracking-widest leading-tight mb-0.5"></p>
                <p id="alertMessage" class="text-sm font-bold opacity-80"></p>
            </div>
        </div>
        <button onclick="hideAlert()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-emerald-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                @if(isset($subject))
                    Subject Units
                @else
                    Academic Units
                @endif
            </h2>
        </div>
        <div class="flex items-center gap-4">
            @if(isset($subject))
            <a href="{{ route('admin.unit.index') }}" class="px-6 py-4 rounded-2xl border border-slate-100 dark:border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-50 transition-all">
                Show All Units
            </a>
            @endif
            <button onclick="openUnitModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-emerald-200 dark:shadow-none flex items-center gap-3">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Add New Unit
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Order</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Unit Name</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Parent Subject</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($units as $unit)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8 text-sm font-black text-slate-400">
                        {{ $unit->order }}
                    </td>
                    <td class="px-10 py-8">
                        <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $unit->name }}</p>
                    </td>
                    <td class="px-10 py-8">
                        <span class="text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                            {{ $unit->subject->name }}
                        </span>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <a href="{{ route('admin.unit.topics.index', $unit->id) }}" class="px-3 h-10 flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all border border-emerald-200 dark:border-emerald-800 text-[11px] font-black uppercase tracking-widest gap-2">
                                <i data-lucide="book" class="w-4 h-4"></i> Topics
                            </a>
                            <button onclick="editUnit({{ $unit->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteUnit({{ $unit->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="layers" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No units found. Expand your subject now!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Unit Modal -->
<div id="unitModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-[#0b1120] w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add New Unit</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Configure unit details</p>
                </div>
                <button onclick="closeUnitModal()" class="w-12 h-12 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white rounded-2xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="unitForm" class="p-8 lg:p-10">
                @csrf
                <input type="hidden" id="unit_id_pk" name="id">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Parent Subject -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Parent Subject <span class="text-red-600">*</span></label>
                        @if(isset($subject))
                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                            <div class="w-full bg-slate-100 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-500">
                                {{ $subject->name }}
                            </div>
                        @else
                            <select name="subject_id" id="subject_id" required
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->course->name }})</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <!-- Unit Name -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Unit Name <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="unit_name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="e.g. Unit 1: Introduction">
                    </div>

                    <!-- Order -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Display Order</label>
                        <input type="number" name="order" id="unit_order" value="0"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <button type="button" onclick="closeUnitModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center justify-center gap-3">
                        <span id="btnText">Save Unit</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const modal = document.getElementById('unitModal');
    const form = document.getElementById('unitForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    function showAlert(type, message) {
        const container = document.getElementById('alertContainer');
        const box = document.getElementById('alertBox');
        const title = document.getElementById('alertTitle');
        const msg = document.getElementById('alertMessage');
        const iconDiv = document.getElementById('alertIcon');
        container.classList.remove('hidden');
        title.innerText = type === 'success' ? 'Success Operation' : 'Action Required';
        msg.innerText = message;
        if (type === 'success') {
            box.className = 'p-5 rounded-[1.5rem] flex items-center justify-between border bg-emerald-50 border-emerald-100 dark:bg-emerald-900/10 dark:border-emerald-800/30 text-emerald-700 dark:text-emerald-400';
            iconDiv.className = 'w-10 h-9 rounded-xl flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/20';
        } else {
            box.className = 'p-5 rounded-[1.5rem] flex items-center justify-between border bg-red-50 border-red-100 dark:bg-red-900/10 dark:border-red-800/30 text-red-700 dark:text-red-400';
            iconDiv.className = 'w-10 h-9 rounded-xl flex items-center justify-center bg-red-100 dark:bg-red-900/20';
        }
        setTimeout(hideAlert, 3000);
    }

    function hideAlert() {
        document.getElementById('alertContainer').classList.add('hidden');
    }

    function openUnitModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (!isEdit) {
            form.reset();
            document.getElementById('unit_id_pk').value = '';
            modalTitle.innerText = 'Add New Unit';
            btnText.innerText = 'Save Unit';
        }
    }

    function closeUnitModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editUnit(id) {
        openUnitModal(true);
        modalTitle.innerText = 'Edit Unit';
        btnText.innerText = 'Update Unit';
        fetch(`/admin/unit/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('unit_id_pk').value = data.id;
                if(document.getElementById('subject_id')) {
                    document.getElementById('subject_id').value = data.subject_id;
                }
                document.getElementById('unit_name').value = data.name;
                document.getElementById('unit_order').value = data.order;
            });
    }

    form.onsubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('unit_id_pk').value;
        const url = id ? `/admin/unit/${id}` : '/admin/unit';
        const method = id ? 'PUT' : 'POST';
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);        
        if(id) {
            data['_method'] = 'PUT';
        }
        submitBtn.disabled = true;
        btnText.innerText = 'Processing...';
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'success') {
                showAlert('success', result.message);
                closeUnitModal();
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('error', result.message || 'Validation failed.');
            }
        } catch (error) {
            showAlert('error', 'Critical operational error.');
        } finally {
            submitBtn.disabled = false;
        }
    };

    function deleteUnit(id) {
        if(confirm('Are you sure you want to delete this unit?')) {
            fetch(`/admin/unit/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showAlert('error', 'Failed to delete unit.');
                }
            });
        }
    }
</script>
@endsection
