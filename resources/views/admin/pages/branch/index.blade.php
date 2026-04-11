@extends('admin.layouts.main')

@section('title', 'Branch Management')

@section('content')
<div class="mb-12">
    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">BRANCHES INVENTORY</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500">Manage your branch network and credentials</p>
</div>
<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Active Branches</h2>
        </div>
        <button onclick="openBranchModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center gap-3">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Add New Branch
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">ID</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Branch Identity</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Contact & Location</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Branch Access</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($branches as $branch)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8">
                        <span class="text-sm font-black text-slate-400">#{{ str_pad($branch->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors mb-0.5">{{ $branch->branch_name }}</p>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-tighter">{{ $branch->branch_id }}</p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex flex-col gap-1">
                            <p class="text-[12px] font-bold text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-blue-500"></i>
                                {{ $branch->contact }}
                            </p>
                            <p class="text-[11px] font-medium text-slate-400 flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                {{ $branch->city }}, {{ $branch->state }}
                            </p>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex flex-col gap-1">
                            <p class="text-[12px] font-black text-slate-700 dark:text-slate-200 flex items-center gap-1.5">
                                <i data-lucide="key" class="w-3.5 h-3.5 text-orange-500"></i>
                                {{ $branch->password }}
                            </p>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-center">
                        <span class="text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest 
                            {{ $branch->status === 'Active' ? 'bg-emerald-100 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' }}">
                            {{ $branch->status }}
                        </span>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editBranch({{ $branch->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteBranch({{ $branch->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="unplug" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No branches found. Start by adding one!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Branch Modal -->
<div id="branchModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-[#0b1120] w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add New Branch</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Enter branch details below</p>
                </div>
                <button onclick="closeBranchModal()" class="w-12 h-12 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white rounded-2xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="branchForm" class="p-8 lg:p-10">
                @csrf
                <input type="hidden" id="branch_id_pk" name="id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Branch Name -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Branch Name <span class="text-red-600">*</span></label>
                        <input type="text" name="branch_name" id="branch_name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="Enter Branch Name">
                    </div>

                    <!-- Branch ID (Code) -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Branch ID / Code <span class="text-red-600">*</span></label>
                        <input type="text" name="branch_id" id="branch_id" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            value="rk<?= mt_rand(10000, 99999) ?>" placeholder="Enter Branch ID">
                    </div>

                    <!-- Contact -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Contact Number <span class="text-red-600">*</span></label>
                        <input type="text" name="contact" id="contact" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="Enter Contact Number">
                    </div>

                    <!-- City -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">City <span class="text-red-600">*</span></label>
                        <input type="text" name="city" id="city" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="Enter City">
                    </div>

                    <!-- State -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">State <span class="text-red-600">*</span></label>
                        <input type="text" name="state" id="state" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="Enter State">
                    </div>

                    <!-- Country -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Country <span class="text-red-600">*</span></label>
                        <input type="text" name="country" id="country" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="Enter Country">
                    </div>

                    <!-- Postal Code -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Pin Code/Postal Code <span class="text-red-600">*</span></label>
                        <input type="text" name="postal" id="postal" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="Enter Pin Code/Postal Code">
                    </div>

                    <!-- Status -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Status <span class="text-red-600">*</span></label>
                        <select name="status" id="status" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="col-span-full">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Branch Address <span class="text-red-600">*</span></label>
                        <textarea name="branch_address" id="branch_address" rows="3" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all resize-none"
                            placeholder="Enter full address..."></textarea>
                    </div>

                    <!-- Password -->
                    <div class="col-span-full">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">
                            Branch Access Password
                            <span id="pwdHint" class="lowercase font-normal text-slate-500">(Leave blank to keep current)</span>
                            <span class="text-red-600">*</span>
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 pr-14 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                                placeholder="••••••••">

                            <!-- Eye Button -->
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition-all">
                                <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <button type="button" onclick="closeBranchModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center justify-center gap-3">
                        <span id="btnText">Save Branch</span>
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
    const modal = document.getElementById('branchModal');
    const form = document.getElementById('branchForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const pwdHint = document.getElementById('pwdHint');

    function openBranchModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (!isEdit) {
            form.reset();
            document.getElementById('branch_id_pk').value = '';
            modalTitle.innerText = 'Add New Branch';
            btnText.innerText = 'Save Branch';
            pwdHint.style.display = 'none';
            document.getElementById('password').required = true;
        }
    }

    function closeBranchModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editBranch(id) {
        openBranchModal(true);
        modalTitle.innerText = 'Edit Branch';
        btnText.innerText = 'Update Branch';
        pwdHint.style.display = 'inline';
        document.getElementById('password').required = false;

        fetch(`/admin/branch/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('branch_id_pk').value = data.id;
                document.getElementById('branch_name').value = data.branch_name;
                document.getElementById('branch_id').value = data.branch_id;
                document.getElementById('contact').value = data.contact;
                document.getElementById('city').value = data.city;
                document.getElementById('state').value = data.state;
                document.getElementById('country').value = data.country;
                document.getElementById('postal').value = data.postal;
                document.getElementById('status').value = data.status;
                document.getElementById('branch_address').value = data.branch_address;
                document.getElementById('password').value = data.password;
            });
    }

    form.onsubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('branch_id_pk').value;
        const url = id ? `/admin/branch/${id}` : '/admin/branch';
        const method = id ? 'PUT' : 'POST';

        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        // Convert to PUT if needed for Laravel
        if (id) {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message || 'Validation failed. Please check your input.'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!'
            });
        } finally {
            submitBtn.disabled = false;
        }
    };

    function deleteBranch(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            background: document.documentElement.classList.contains('dark') ? '#0b1120' : '#fff',
            color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/branch/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', data.message, 'success').then(() => {
                                window.location.reload();
                            });
                        }
                    });
            }
        });
    }

    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons(); // refresh icon
    }
</script>
@endsection