@extends('admin.layouts.main')

@section('title', 'Contact Inquiries')

@section('content')
<div class="mb-12">
    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">CONTACT INQUIRIES</h1>
    <p class="text-sm font-bold text-slate-400 dark:text-slate-500">View and manage inquiries from the contact form</p>
</div>

@if(session('success'))
<div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-600 text-sm font-medium">
    {{ session('success') }}
</div>
@endif

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Recent Inquiries</h2>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Date</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Contact Info</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Message</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($contacts as $contact)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8 whitespace-nowrap">
                        <p class="text-[13px] font-black text-slate-900 dark:text-white">{{ $contact->created_at->format('d M, Y') }}</p>
                        <p class="text-[11px] font-bold text-slate-400">{{ $contact->created_at->format('h:i A') }}</p>
                    </td>
                    <td class="px-10 py-8">
                        <div>
                            <p class="text-[14px] font-black text-slate-900 dark:text-white mb-1">{{ $contact->name }}</p>
                            <div class="flex flex-col gap-1">
                                <p class="text-[11px] font-bold text-slate-500 flex items-center gap-1.5">
                                    <i data-lucide="mail" class="w-3 h-3"></i>
                                    {{ $contact->email }}
                                </p>
                                <p class="text-[11px] font-bold text-slate-500 flex items-center gap-1.5">
                                    <i data-lucide="phone" class="w-3 h-3"></i>
                                    {{ $contact->phone }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-8 min-w-[300px]">
                        <p class="text-[13px] font-medium text-slate-600 dark:text-slate-300 leading-relaxed italic">
                            "{{ $contact->message }}"
                        </p>
                    </td>
                    <td class="px-10 py-8 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inquiry?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700 shadow-sm" title="Delete Inquiry">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="mail" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No contact inquiries found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($contacts->hasPages())
    <div class="p-8 border-t border-slate-100 dark:border-slate-800">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
@endsection
