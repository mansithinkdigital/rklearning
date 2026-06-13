@extends('admin.layouts.main')

@section('title', 'Students Management')

@section('content')
<div class="mb-12">
    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">STUDENTS INVENTORY</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500">Manage your student details and credentials</p>
</div>

@if(session('success'))
<div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-600 text-sm font-medium">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 px-4 py-3 rounded-xl bg-red-50 text-red-600 text-sm font-medium">
    <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="mb-6 bg-white dark:bg-[#0b1120] rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm p-6">
    <form action="{{ route('admin.student.index') }}" method="GET" id="filterForm" class="flex flex-wrap items-end gap-4">
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter by Course</label>
            <select name="course_id" class="block w-48 px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
                <option value="">All Courses</option>
                @foreach($allCourses as $course)
                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Year</label>
            <select name="year" class="block w-32 px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
                <option value="">All Years</option>
                @for($y = date('Y'); $y >= 2023; $y--)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="block px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="block px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-blue-500/20 transition-all">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all flex items-center gap-2 shadow-lg shadow-blue-200 dark:shadow-none">
                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                Filter
            </button>
            <button type="button" onclick="exportData('excel')" class="px-5 py-2.5 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all flex items-center gap-2 shadow-lg shadow-emerald-200 dark:shadow-none">
                <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                Excel
            </button>
            <button type="button" onclick="exportData('pdf')" class="px-5 py-2.5 bg-rose-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-all flex items-center gap-2 shadow-lg shadow-rose-200 dark:shadow-none">
                <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                PDF
            </button>
            @if(request()->anyFilled(['course_id', 'year', 'from_date', 'to_date']))
            <a href="{{ route('admin.student.index') }}" class="px-5 py-2.5 bg-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-300 transition-all flex items-center gap-2">
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Student Inventory</h2>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">ID</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Basic Details</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Contact Info</th>
                    <!-- <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Academic Status</th> -->
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Branch</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($students as $student)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <span class="text-sm font-black text-slate-400">#{{ str_pad($student->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex items-center gap-3">
                            @if($student->image)
                            <img src="{{ asset($student->image) }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                            @else
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors mb-0.5">{{ $student->name }}</p>
                                <p class="text-[11px] font-bold text-slate-400 tracking-tighter">{{ $student->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex flex-col gap-1">
                            <p class="text-[12px] font-bold text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-blue-500"></i>
                                {{ $student->phone }}
                            </p>
                            <!-- <p class="text-[11px] font-medium text-slate-400 flex items-center gap-1.5 line-clamp-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                {{ $student->address }}
                            </p> -->
                        </div>
                    </td>                    
                    <td class="px-10 py-8">
                        <div class="flex flex-col gap-1">
                            <p class="text-[12px] font-black text-slate-700 dark:text-slate-200">
                                @php
                                $branch = $branches->firstWhere('id', $student->branch_id);
                                @endphp
                                {{ $branch ? $branch->branch_name : 'N/A' }}
                            </p>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='editStudent(@json($student))' class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="users" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No students found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Student Edit Modal -->
<div id="studentModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-[#0b1120] w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Student</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Update student details</p>
                </div>
                <button onclick="closeStudentModal()" class="w-12 h-12 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white rounded-2xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="studentForm" method="POST" action="" class="p-8 lg:p-10">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Full Name <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>

                    <!-- Email -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Email <span class="text-red-600">*</span></label>
                        <input type="email" name="email" id="email" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>

                    <!-- Contact -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Contact Number <span class="text-red-600">*</span></label>
                        <input type="text" name="phone" id="phone" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>

                    <!-- Branch -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Branch <span class="text-red-600">*</span></label>
                        <select name="branch_id" id="branch_id" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="col-span-full">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Address <span class="text-red-600">*</span></label>
                        <textarea name="address" id="address" rows="3" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all resize-none"></textarea>
                    </div>

                    <!-- Password -->
                    <div class="col-span-full">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">
                            Override Student Password
                            <span class="lowercase font-normal text-slate-500">(Leave blank to keep current hashed password)</span>
                        </label>

                        <div class="relative">
                            <input
                                type="text"
                                name="new_password"
                                id="new_password"
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 pr-14 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                                placeholder="Enter a new password here if you wish to change it...">
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <button type="button" onclick="closeStudentModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center justify-center gap-3">
                        <span>Save Changes</span>
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
    const modal = document.getElementById('studentModal');
    const form = document.getElementById('studentForm');

    function openStudentModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeStudentModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editStudent(student) {
        form.action = `/admin/student/${student.id}`;
        document.getElementById('name').value = student.name || '';
        document.getElementById('email').value = student.email || '';
        document.getElementById('phone').value = student.phone || '';
        document.getElementById('branch_id').value = student.branch_id || '';
        document.getElementById('address').value = student.address || '';
        document.getElementById('new_password').value = '';
        openStudentModal();
    }

    function exportData(type) {
        const filterForm = document.getElementById('filterForm');
        const originalAction = filterForm.action;

        // Create a hidden input for export type
        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = type;
        filterForm.appendChild(typeInput);

        // Change action to export route
        filterForm.action = "{{ route('admin.student.export') }}";
        filterForm.submit();

        // Reset form for future use
        setTimeout(() => {
            filterForm.action = originalAction;
            typeInput.remove();
        }, 100);
    }
</script>
@endsection