@extends('admin.layouts.main')

@section('title', 'Offline Payments')

@section('content')
<div class="mb-12 text-center lg:text-left">
    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">OFFLINE PAYMENTS</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Manage offline fees, discounts, and installments</p>
</div>

@if(session('success'))
<div class="mb-8 p-5 rounded-[1.5rem] bg-emerald-50 border border-emerald-100 flex items-center justify-between animate-reveal">
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </div>
        <div>
            <p class="text-[11px] font-black uppercase tracking-widest text-emerald-600 leading-tight">Success</p>
            <p class="text-sm font-bold text-emerald-800 opacity-80">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-8 p-5 rounded-[1.5rem] bg-red-50 border border-red-100 flex items-center justify-between animate-reveal">
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-red-500 text-white flex items-center justify-center">
            <i data-lucide="x-circle" class="w-5 h-5"></i>
        </div>
        <div>
            <p class="text-[11px] font-black uppercase tracking-widest text-red-600 leading-tight">Error</p>
            <p class="text-sm font-bold text-red-800 opacity-80">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-amber-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Offline Payment Records</h2>
        </div>
        <div class="px-4 py-2 bg-amber-50 dark:bg-amber-900/20 rounded-xl text-[10px] font-black text-amber-500 uppercase tracking-widest">
            Count: {{ $offlineEnrollments->count() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Student & Course</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Payment Stats</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Installment</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($offlineEnrollments as $enrollment)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-8 py-8">
                        <div>
                            <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-amber-600 transition-colors mb-0.5">{{ $enrollment->student_name }}</p>
                            <p class="text-[11px] font-bold text-slate-400 mb-2">{{ $enrollment->student_email }}</p>
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded text-[9px] font-bold uppercase tracking-widest">{{ $enrollment->course_name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-8">
                        <div class="space-y-1">
                            <p class="text-[11px] font-bold text-slate-500">Price: <span class="text-slate-900 dark:text-white">₹{{ number_format($enrollment->original_price, 2) }}</span></p>
                            <p class="text-[11px] font-bold text-emerald-600">Discount: <span class="font-black">{{ $enrollment->discount }}%</span></p>
                            <p class="text-[11px] font-bold text-indigo-600">Paid: <span class="font-black">₹{{ number_format($enrollment->paid_amount, 2) }}</span></p>
                            <p class="text-[11px] font-bold text-rose-600">Balance: <span class="font-black">₹{{ number_format($enrollment->balance_amount, 2) }}</span></p>
                        </div>
                    </td>
                    <td class="px-8 py-8">
                        @if($enrollment->next_installment_date)
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Next Date</span>
                                <span class="text-[12px] font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($enrollment->next_installment_date)->format('d M, Y') }}</span>
                            </div>
                        @else
                            <span class="text-[11px] text-slate-400 italic">No installment set</span>
                        @endif
                    </td>
                    <td class="px-8 py-8 text-center">
                        <span class="text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest 
                            {{ $enrollment->status === 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-600' }}">
                            {{ $enrollment->status }}
                        </span>
                    </td>
                    <td class="px-8 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="openPaymentModal({{ json_encode($enrollment) }})" class="p-3 bg-amber-100 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all" title="Update Payment">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>

                            @if(isset($enrollment->receipts) && count($enrollment->receipts) > 0)
                                <button onclick='openReceiptHistoryModal(@json($enrollment))' class="p-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-all flex items-center gap-1" title="Receipt History">
                                    <i data-lucide="history" class="w-4 h-4"></i>
                                    <span class="text-[9px] font-black">{{ count($enrollment->receipts) }}</span>
                                </button>
                            @elseif($enrollment->receipt_file)
                                <a href="{{ asset($enrollment->receipt_file) }}" target="_blank" class="p-3 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all" title="View Receipt">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                            @endif

                            @if($enrollment->status === 'pending')
                            <form action="{{ route('admin.enrollments.approve', ['user' => $enrollment->user_id, 'course' => $enrollment->course_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200" title="Approve Enrollment">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('admin.enrollments.destroy', ['user' => $enrollment->user_id, 'course' => $enrollment->course_id]) }}" method="POST" onsubmit="return confirm('Reject this request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-10 text-center text-xs font-bold text-slate-400 italic">No offline records found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Payment Management Modal -->
<div id="paymentModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closePaymentModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-[#0b1120] rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100 dark:border-slate-800">
            <form id="paymentForm" method="POST">
                @csrf
                <div class="p-8 lg:p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Manage Payment</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1" id="modalStudentName"></p>
                        </div>
                        <button type="button" onclick="closePaymentModal()" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 transition-colors flex items-center justify-center">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Course Original Price</label>
                            <input type="text" id="coursePrice" disabled class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Discount (%)</label>
                                <input type="number" name="discount" id="discountInput" oninput="calculateBalance()" step="0.01" min="0" max="100" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Discount Amount (₹)</label>
                                <input type="text" id="discountAmountDisplay" disabled class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-400">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Payable (₹)</label>
                            <input type="text" id="totalPayableDisplay" disabled class="w-full px-5 py-4 bg-emerald-50 dark:bg-emerald-900/10 border-none rounded-2xl text-sm font-black text-emerald-600">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Amount Paid (₹)</label>
                                <input type="number" name="paid_amount" id="paidInput" oninput="calculateBalance()" required class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Balance Due (₹)</label>
                                <input type="text" id="balanceDisplay" disabled class="w-full px-5 py-4 bg-rose-50 dark:bg-rose-900/10 border-none rounded-2xl text-sm font-black text-rose-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Next Installment Date</label>
                            <input type="date" name="next_installment_date" id="installmentDate" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="p-8 lg:p-10 bg-slate-50 dark:bg-slate-800/40 flex gap-4">
                    <button type="button" onclick="closePaymentModal()" class="flex-1 px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-8 py-4 bg-amber-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-amber-700 transition-all shadow-xl shadow-amber-500/20">
                        Update Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Receipt History Modal -->
<div id="receiptHistoryModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeReceiptHistoryModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-[#0b1120] rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100 dark:border-slate-800">
            <div class="p-8 lg:p-10">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Receipt History</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1" id="historyStudentName"></p>
                    </div>
                    <button type="button" onclick="closeReceiptHistoryModal()" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 transition-colors flex items-center justify-center">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-100 dark:border-slate-800">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Receipt No</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="receiptHistoryBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-8 lg:p-10 bg-slate-50 dark:bg-slate-800/40">
                <button type="button" onclick="closeReceiptHistoryModal()" class="w-full px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openPaymentModal(enrollment) {
        document.getElementById('modalStudentName').textContent = enrollment.student_name + ' - ' + enrollment.course_name;
        document.getElementById('coursePrice').value = enrollment.original_price;
        document.getElementById('discountInput').value = enrollment.discount;
        document.getElementById('paidInput').value = enrollment.paid_amount;
        document.getElementById('installmentDate').value = enrollment.next_installment_date;
 
        const form = document.getElementById('paymentForm');
        form.action = `/admin/payments/offline/${enrollment.id}/update`;
        calculateBalance();
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    function openReceiptHistoryModal(enrollment) {
        document.getElementById('historyStudentName').textContent = enrollment.student_name + ' - ' + enrollment.course_name;
        
        const body = document.getElementById('receiptHistoryBody');
        body.innerHTML = '';
        
        enrollment.receipts.forEach(receipt => {
            const date = new Date(receipt.created_at).toLocaleDateString('en-IN', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            
            const amount = parseFloat(receipt.amount_paid).toLocaleString('en-IN', {
                style: 'currency',
                currency: 'INR'
            });

            const row = `
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-6 py-4">
                        <span class="text-[12px] font-black text-slate-900 dark:text-white">${receipt.receipt_no}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">${date}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-[12px] font-black text-emerald-600">${amount}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="/${receipt.receipt_file}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-700">
                            <i data-lucide="external-link" class="w-3 h-3"></i>
                            View
                        </a>
                    </td>
                </tr>
            `;
            body.insertAdjacentHTML('beforeend', row);
        });
        
        // Re-initialize lucide icons for new content
        lucide.createIcons();
        
        document.getElementById('receiptHistoryModal').classList.remove('hidden');
    }

    function closeReceiptHistoryModal() {
        document.getElementById('receiptHistoryModal').classList.add('hidden');
    }

    function calculateBalance() {
        const price = parseFloat(document.getElementById('coursePrice').value) || 0;
        const discountPercent = parseFloat(document.getElementById('discountInput').value) || 0;
        const paid = parseFloat(document.getElementById('paidInput').value) || 0;
        
        // Calculate discount amount based on original course value
        const discountAmount = (price * discountPercent) / 100;
        const totalPayable = price - discountAmount;
        const balance = totalPayable - paid;
        
        // Update displays
        document.getElementById('discountAmountDisplay').value = '₹' + discountAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('totalPayableDisplay').value = '₹' + totalPayable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('balanceDisplay').value = '₹' + balance.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
</script>
@endsection
