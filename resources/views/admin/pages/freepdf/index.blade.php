@extends('admin.layouts.main')

@section('title', 'Free PDF Management')

@section('content')
<div class="mb-12">
    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">FREE PDF REPOSITORY</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500">Manage complimentary study materials and brochures</p>
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
            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Academic Documents</h2>
        </div>
        <button onclick="openFreePdfModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center gap-3">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Upload New PDF
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">ID</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Document Name</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Hierarchy Links</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">PDF</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($freePdfs as $pdf)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <span class="text-sm font-black text-slate-400">#{{ str_pad($pdf->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-10 py-8">
                        <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $pdf->pdf_name }}</p>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-black px-2 py-1 rounded-lg uppercase tracking-widest bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 w-fit">
                                {{ $pdf->course->name }}
                            </span>
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">
                                {{ $pdf->unit->subject->name ?? 'No Subject' }} > {{ $pdf->unit->name ?? 'No Unit' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <a href="{{ asset('admin/uploads/freepdf/' . $pdf->pdf_file) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-red-50 dark:bg-red-900/10 text-red-600 rounded-xl hover:scale-110 transition-all border border-red-100 dark:border-red-800/20">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </a>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='editFreePdf(@json($pdf))' class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteFreePdf({{ $pdf->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="files" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No PDF documents discovered. Upload your first material!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Free PDF Modal -->
<div id="freePdfModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-[#0b1120] w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Upload PDF Document</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Provide document metadata</p>
                </div>
                <button onclick="closeFreePdfModal()" class="w-12 h-12 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white rounded-2xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="freePdfForm" class="p-8 lg:p-10" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="pdf_id_pk" name="id">
                <div class="grid grid-cols-1 gap-6">
                    <!-- PDF File Input -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">PDF Document <span class="text-red-600">*</span></label>
                        <div class="relative group">
                            <div id="filePreview" class="w-full h-32 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-red-500">
                                <i data-lucide="file-up" class="w-8 h-8 text-slate-300 mb-2"></i>
                                <p id="fileNameDisplay" class="text-[11px] font-bold text-slate-400">Drag & Drop or Click to Select PDF</p>
                            </div>
                            <input type="file" name="pdf_file" id="pdfFileInput" class="absolute inset-0 opacity-0 cursor-pointer" accept=".pdf" onchange="handleFileSelect(this)">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Course Select -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Linked Course <span class="text-red-600">*</span></label>
                            <select name="course_id" id="course_id" required onchange="loadSubjects(this.value, 'subject_id')"
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                                <option value="">Choose Course</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Select -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Linked Subject <span class="text-red-600">*</span></label>
                            <select id="subject_id" required onchange="loadUnits(this.value, 'unit_id')"
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                                <option value="">First Choose Course</option>
                            </select>
                        </div>

                        <!-- Unit Select -->
                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Linked Unit <span class="text-red-600">*</span></label>
                            <select name="unit_id" id="unit_id" required
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                                <option value="">First Choose Subject</option>
                            </select>
                        </div>
                    </div>

                    <!-- PDF Name -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Document Display Title <span class="text-red-600">*</span></label>
                        <input type="text" name="pdf_name" id="pdf_name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="e.g. Tally Prime User Guide 2026">
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <button type="button" onclick="closeFreePdfModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center justify-center gap-3">
                        <span id="btnText">Publish Document</span>
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
    const modal = document.getElementById('freePdfModal');
    const form = document.getElementById('freePdfForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const filePreview = document.getElementById('filePreview');

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

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            fileNameDisplay.innerText = fileName;
            filePreview.classList.remove('border-slate-200');
            filePreview.classList.add('border-blue-500', 'bg-blue-50/50');
        }
    }

    function openFreePdfModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (!isEdit) {
            form.reset();
            document.getElementById('pdf_id_pk').value = '';
            modalTitle.innerText = 'Upload PDF Document';
            btnText.innerText = 'Publish Document';
            fileNameDisplay.innerText = 'Drag & Drop or Click to Select PDF';
            filePreview.className = 'w-full h-32 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-red-500';
            document.getElementById('pdfFileInput').required = true;
        }
    }

    function closeFreePdfModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    async function loadSubjects(courseId, targetId, selectedId = null) {
        const target = document.getElementById(targetId);
        target.innerHTML = '<option value="">Loading...</option>';
        try {
            const response = await fetch(`/admin/get-subjects/${courseId}`);
            const subjects = await response.json();
            target.innerHTML = '<option value="">Choose Subject</option>';
            subjects.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.name;
                if (selectedId && s.id == selectedId) opt.selected = true;
                target.appendChild(opt);
            });
            if (selectedId) loadUnits(selectedId, targetId.replace('subject', 'unit'));
        } catch (e) {
            target.innerHTML = '<option value="">Error loading</option>';
        }
    }

    async function loadUnits(subjectId, targetId, selectedId = null) {
        const target = document.getElementById(targetId);
        target.innerHTML = '<option value="">Loading...</option>';
        try {
            const response = await fetch(`/admin/get-units-by-subject/${subjectId}`);
            const units = await response.json();
            target.innerHTML = '<option value="">Choose Unit</option>';
            units.forEach(u => {
                const opt = document.createElement('option');
                opt.value = u.id;
                opt.textContent = u.name;
                if (selectedId && u.id == selectedId) opt.selected = true;
                target.appendChild(opt);
            });
        } catch (e) {
            target.innerHTML = '<option value="">Error loading</option>';
        }
    }

    async function editFreePdf(pdf) {
        openFreePdfModal(true);
        modalTitle.innerText = 'Update Document';
        btnText.innerText = 'Update Changes';
        document.getElementById('pdfFileInput').required = false;

        document.getElementById('pdf_id_pk').value = pdf.id;
        document.getElementById('course_id').value = pdf.course_id;
        document.getElementById('pdf_name').value = pdf.pdf_name;
        fileNameDisplay.innerText = `Current File: ${pdf.pdf_file}`;

        // Load subjects and units
        if (pdf.unit && pdf.unit.subject_id) {
            await loadSubjects(pdf.course_id, 'subject_id', pdf.unit.subject_id);
            await loadUnits(pdf.unit.subject_id, 'unit_id', pdf.unit_id);
        } else {
            loadSubjects(pdf.course_id, 'subject_id');
        }
    }

    form.onsubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('pdf_id_pk').value;
        const url = id ? `/admin/free-pdf/${id}` : '/admin/free-pdf';

        const formData = new FormData(form);
        if (id) {
            formData.append('_method', 'PUT');
        }

        submitBtn.disabled = true;
        btnText.innerText = 'Processing...';

        try {
            const response = await fetch(url, {
                method: 'POST', // POST with _method PUT works for FormData
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                showAlert('success', result.message);
                closeFreePdfModal();
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

    function deleteFreePdf(id) {
        if (confirm('Are you sure you want to delete this PDF document?')) {
            fetch(`/admin/free-pdf/${id}`, {
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
                        showAlert('error', 'Failed to delete PDF.');
                    }
                });
        }
    }
</script>
@endsection