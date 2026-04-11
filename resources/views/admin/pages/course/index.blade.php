@extends('admin.layouts.main')

@section('title', 'Courses Inventory')

@section('content')
<div class="mb-12">
    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">COURSES INVENTORY</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500">Manage your educational catalog and materials</p>
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
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Active Courses</h2>
        </div>
        <button onclick="openCourseModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center gap-3">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Add New Course
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">ID</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course Image</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Course Identity</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($courses as $course)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <span class="text-sm font-black text-slate-400">#{{ str_pad($course->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-10 py-8">
                        <div class="w-20 h-14 rounded-xl border border-slate-100 dark:border-slate-800 overflow-hidden bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center">
                            <img src="{{ asset('admin/uploads/courseimg/' . $course->image) }}" alt="{{ $course->name }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors mb-0.5">{{ $course->name }}</p>
                            <p class="text-[11px] font-bold text-slate-400 line-clamp-1 max-w-[300px]">{{ $course->description }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-center">
                        <span class="text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest 
                            {{ $course->status === 'Active' ? 'bg-emerald-100 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' }}">
                            {{ $course->status }}
                        </span>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editCourse({{ $course->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteCourse({{ $course->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="box" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No courses listed. Launch your first course!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Course Modal -->
<div id="courseModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-[#0b1120] w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add New Course</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Register course information</p>
                </div>
                <button onclick="closeCourseModal()" class="w-12 h-12 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white rounded-2xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="courseForm" class="p-8 lg:p-10" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="course_id_pk" name="id">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Course Image Preview & Input -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Course Thumbnail</label>
                        <div class="relative group">
                            <div id="imagePreview" class="w-full h-40 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-blue-500">
                                <i data-lucide="image" class="w-8 h-8 text-slate-300 mb-2"></i>
                                <p class="text-[11px] font-bold text-slate-400">Click to upload file</p>
                            </div>
                            <input type="file" name="image" id="imageInput" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>

                    <!-- Course Name -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Course Title</label>
                        <input type="text" name="name" id="course_name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="e.g. Tally Prime Professional">
                    </div>

                    <!-- Description -->
                    <div class="col-span-full">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Course Description</label>
                        <textarea name="description" id="course_description" rows="4" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all resize-none"
                            placeholder="Enter course curriculum or details..."></textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Live Status</label>
                        <select name="status" id="course_status" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <button type="button" onclick="closeCourseModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center justify-center gap-3">
                        <span id="btnText">Save Course</span>
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
    const modal = document.getElementById('courseModal');
    const form = document.getElementById('courseForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const imagePreview = document.getElementById('imagePreview');

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
            iconDiv.className = 'w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/20';
        } else {
            box.className = 'p-5 rounded-[1.5rem] flex items-center justify-between border bg-red-50 border-red-100 dark:bg-red-900/10 dark:border-red-800/30 text-red-700 dark:text-red-400';
            iconDiv.className = 'w-10 h-10 rounded-xl flex items-center justify-center bg-red-100 dark:bg-red-900/20';
        }

        // Auto hide after 5 seconds
        setTimeout(hideAlert, 5000);
    }

    function hideAlert() {
        document.getElementById('alertContainer').classList.add('hidden');
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openCourseModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (!isEdit) {
            form.reset();
            document.getElementById('course_id_pk').value = '';
            modalTitle.innerText = 'Launch New Course';
            btnText.innerText = 'Publish Course';
            imagePreview.innerHTML = `<i data-lucide="image" class="w-8 h-8 text-slate-300 mb-2"></i><p class="text-[11px] font-bold text-slate-400">Click to upload file</p>`;
            lucide.createIcons();
            document.getElementById('imageInput').required = true;
        }
    }

    function closeCourseModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editCourse(id) {
        openCourseModal(true);
        modalTitle.innerText = 'Edit Course';
        btnText.innerText = 'Update Changes';
        document.getElementById('imageInput').required = false;

        fetch(`/admin/course/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('course_id_pk').value = data.id;
                document.getElementById('course_name').value = data.name;
                document.getElementById('course_description').value = data.description;
                document.getElementById('course_status').value = data.status;
                imagePreview.innerHTML = `<img src="/admin/uploads/courseimg/${data.image}" class="w-full h-full object-cover">`;
            });
    }

    form.onsubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('course_id_pk').value;
        const url = id ? `/admin/course/${id}` : '/admin/course';
        
        const formData = new FormData(form);
        if (id) {
            formData.append('_method', 'PUT');
        }

        submitBtn.disabled = true;
        btnText.innerText = 'Processing...';

        try {
            const response = await fetch(url, {
                method: 'POST', // Always POST when using FormData, _method handles PUT
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                showAlert('success', result.message);
                closeCourseModal();
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('error', result.message || 'Validation failed. Check inputs.');
            }
        } catch (error) {
            showAlert('error', 'Critical storage interface error.');
        } finally {
            submitBtn.disabled = false;
        }
    };

    function deleteCourse(id) {
        if(confirm('Are you absolutely sure you want to delete this course? This action cannot be undone.')) {
            fetch(`/admin/course/${id}`, {
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
                    showAlert('error', 'Failed to delete course.');
                }
            });
        }
    }
</script>
@endsection
