@extends('layouts.student')
@section('title', 'My Profile')
@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Header / Banner -->
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
            <div class="absolute -bottom-16 left-10">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-3xl bg-white p-2 shadow-xl">
                        <div class="w-full h-full bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 overflow-hidden">
                            @if(auth()->user()->image)
                            <img src="{{ asset(auth()->user()->image) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                            <i data-lucide="user" class="w-12 h-12"></i>
                            @endif
                        </div>
                    </div>
                    <label for="profileImageInput" class="absolute bottom-2 right-2 w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center shadow-lg hover:bg-blue-700 transition cursor-pointer">
                        <i data-lucide="camera" class="w-4 h-4"></i>
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-20 px-10 pb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                    <p class="text-slate-500 font-medium">Student • Joined 2026</p>
                </div>
                <div class="px-6 py-2 bg-emerald-50 text-emerald-600 rounded-xl font-bold text-sm border border-emerald-100 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                    Account Active
                </div>
            </div>
            <div id="successAlert" class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-600 text-sm font-medium">
                {{ session('success') }}
            </div>
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <input type="file" name="image" id="profileImageInput" accept="image/*" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block px-1">Full Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition shadow-sm font-medium" placeholder="Full Name">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block px-1">Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-5 py-3 rounded-2xl border border-slate-100 bg-slate-50 text-slate-400 cursor-not-allowed font-medium" placeholder="Email">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block px-1">Phone Number</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '+1 234 567 8900' }}" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition shadow-sm font-medium">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block px-1">Branch</label>
                        <input type="text" value="{{ auth()->user()->branch->branch_name ?? 'N/A' }}" disabled class="w-full px-5 py-3 rounded-2xl border border-slate-100 bg-slate-50 text-slate-400 cursor-not-allowed font-medium">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block px-1">Address</label>
                    <textarea name="address" rows="3" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition shadow-sm font-medium">{{ auth()->user()->address ?? '123 Learning Lane, Knowledge City, EDU 456' }}</textarea>
                </div>
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-slate-400 font-medium italic">Required for your photo-verified certification.</p>
                    <div class="flex space-x-3 w-full sm:w-auto">
                        <button type="button" class="flex-1 sm:flex-none px-8 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Cancel</button>
                        <button type="submit" class="flex-1 sm:flex-none px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        let alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500); // remove after fade
        }
    }, 2000); // 3 seconds
</script>
@endsection