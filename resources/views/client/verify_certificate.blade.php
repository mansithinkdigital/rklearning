@extends('layouts.client')

@section('title', 'Verify Certificate - Rk Institute')

@section('styles')
<style>
    .verification-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .search-section {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        padding: 80px 20px 100px;
        text-align: center;
        position: relative;
    }

    .search-box-wrapper {
        max-width: 650px;
        margin: -50px auto 0;
        position: relative;
        z-index: 10;
    }

    .search-input-group {
        max-width: 600px;
        margin: 30px auto 0;
        position: relative;
    }

    .search-box {
        background: white;
        border-radius: 60px;
        padding: 8px;
        display: flex;
        align-items: center;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        border: 1px solid #e2e8f0;
    }

    .search-input {
        flex: 1;
        width: 100%;
        padding: 16px 20px;
        padding-right: 140px;
        border-radius: 50px;
        border: none;
        font-size: 16px;
        font-weight: 500;
        color: #1e293b;
        background-color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 8px;
        top: 8px;
        bottom: 8px;
        background: #4f46e5;
        color: white;
        border: none;
        padding: 0 25px;
        border-radius: 40px;
        font-weight: 700;
        transition: 0.3s;
    }

    .search-btn:hover {
        background: #3730a3;
        transform: translateY(-1px);
    }

    .certificate-container {
        padding: 40px;
        display: flex;
        justify-content: center;
        background: #f8fafc;
    }

    /* Embedded Certificate Styles (Simplified from certificate_print) */
    .cert-preview {
        width: 100%;
        max-width: 800px;
        aspect-ratio: 1.414 / 1;
        background: white;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .cert-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .cert-content {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
    }

    .cert-field {
        position: absolute;
        color: #0f2441;
        text-align: center;
        font-family: 'Times New Roman', serif;
    }

    .modal-card {
        background: white;
        width: 95%;
        max-width: 1200px;
        border-radius: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        pointer-events: auto;
        display: flex;
        flex-direction: column;
        max-height: 95vh;
    }

    .modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }

    .modal-body {
        padding: 1rem md:padding: 2rem;
        overflow-y: auto;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
    }

    .cert-preview-modal {
        width: 100%;
        max-width: 1100px;
        position: relative;
        aspect-ratio: 1.414 / 1;
        background: white;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-radius: 0.5rem;
        overflow: hidden;
        container-type: inline-size;
    }

    .cert-bg {
        width: 100%;
        height: 100%;
        display: block;
    }

    .cert-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    .cert-field {
        position: absolute;
        color: #0f2441;
        text-align: center;
        font-family: 'Times New Roman', serif;
    }

    .cert-name {
        top: 21.4%;
        left: 0;
        right: 0;
        font-size: 3.2cqw;
        font-weight: bold;
        text-transform: uppercase;
        color: #0f2441;
    }

    .cert-course {
        top: 24.5%;
        left: 0;
        right: 0;
        font-size: 3.2cqw;
        font-weight: bold;
        color: #c56b27;
        text-transform: uppercase;
    }

    .cert-period {
        top: 43.8%;
        left: 0;
        right: 0;
        font-size: 1.8cqw;
        color: #0f2441;
    }

    .cert-skills {
        top: 48%;
        left: 15%;
        right: 15%;
        font-size: 1.4cqw;
        color: #555;
        line-height: 1.4;
        text-align: center;
    }

    .cert-id-val {
        top: 49.5%;
        left: 7.4%;
        width: 15.1%;
        font-size: 1.4cqw;
        font-weight: bold;
        color: #0f2441;
        text-align: center;
    }

    .cert-photo {
        position: absolute;
        top: 40.5%;
        right: 8.4%;
        width: 11.8%;
        height: 21.4%;
        border: 1px solid #0f2441;
        background: white;
        overflow: hidden;
    }

    .cert-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cert-logo-box {
        position: absolute;
        top: 11.9%;
        left: 6.7%;
        width: 10%;
        height: 14.3%;
    }

    .cert-logo-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .cert-website {
        position: absolute;
        top: 83.3%;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 1.6cqw;
        color: #0f2441;
        font-weight: bold;
    }

    .cert-website a {
        color: inherit;
        text-decoration: none;
    }

    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .animate-bounce-subtle {
        animation: bounce-subtle 3s infinite ease-in-out;
    }

    @media (max-width: 768px) {
        .search-section {
            padding: 40px 20px;
        }

        .search-input {
            font-size: 14px;
            padding-right: 110px;
            background-color: white;
        }

        .search-btn {
            padding: 0 15px;
        }
    }

    /* Modal Styles */
    #certModal.hidden {
        display: none;
    }

    #certModal {
        display: block;
    }

    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(8px);
        z-index: 1000;
    }

    .modal-content-wrapper {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1001;
        padding: 20px;
        pointer-events: none;
    }

</style>
@endsection

@section('content')
<div class="pt-5 pb-20 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="verification-card">
            <!-- Search Header -->
            <div class="search-section">
                <h1 class="text-4xl font-bold text-white mb-3">Certificate Verification</h1>
                <p class="text-indigo-100 text-lg opacity-90">
                    Verify the authenticity of Rk Institute certificates
                </p>
            </div>
            <div class="search-box-wrapper">
                <form action="{{ route('certificate.verify.submit') }}" method="POST">
                    @csrf
                    <div class="search-box">
                        <input
                            type="text"
                            name="certificate_no"
                            class="search-input"
                            placeholder="Enter Certificate Number (e.g., {{ date('Yn') }}-1234)"
                            value="{{ $certId ?? '' }}"
                            required>
                        <button type="submit" class="search-btn">
                            <i class="fa fa-search mr-1"></i> Verify
                        </button>
                    </div>
                </form>
            </div>

            <!-- Result Section -->
            @if(session('error'))
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa fa-times text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Not Found</h3>
                <p class="text-slate-500">{{ session('error') }}</p>
            </div>
            @elseif(isset($user))
            <div class="result-section">
                <!-- Status Header -->
                <div class="bg-emerald-50/50 p-8 text-center border-b border-emerald-100">
                    <div class="inline-flex items-center gap-3 px-6 py-2 bg-emerald-500 text-white rounded-full shadow-lg shadow-emerald-200 animate-bounce-subtle">
                        <i class="fa fa-check-circle"></i>
                        <span class="font-black uppercase tracking-widest text-xs">Authenticity Verified</span>
                    </div>
                    <p class="mt-4 text-slate-500 font-bold text-sm uppercase tracking-tight">Official Record for ID: <span class="text-slate-900 font-black tracking-widest">{{ $certId }}</span></p>
                </div>

                <div class="p-8 md:p-12 space-y-12 relative overflow-hidden group">
                    <div class="relative z-10">
                        <!-- Student & Identity Segment -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                            <div class="flex gap-6 items-start">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                                    <i class="fa fa-user text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1 block">Full Name</span>
                                    <p class="text-3xl font-black text-slate-900 leading-tight">{{ strtoupper($user->name) }}</p>
                                </div>
                            </div>
                            <div class="flex gap-6 items-start">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                                    <i class="fa fa-users text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1 block">Mother's Name</span>
                                    <p class="text-2xl font-black text-slate-900 leading-tight">{{ strtoupper($user->mother_name ?? 'N/A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Course Segment -->
                        <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 relative overflow-hidden mb-12">
                            <div class="relative z-10">
                                <span class="text-indigo-500 text-[10px] font-black uppercase tracking-[0.3em] mb-4 block">Academic Achievement</span>
                                <h3 class="text-3xl font-black text-slate-900 mb-8 max-w-2xl leading-tight">{{ strtoupper($course->name) }}</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-white text-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                            <i class="fa fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 text-[9px] font-black uppercase tracking-widest block">Training Period</span>
                                            <p class="font-bold text-slate-700">{{ $enrollDate }} to {{ date('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-white text-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                            <i class="fa fa-graduation-cap"></i>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 text-[9px] font-black uppercase tracking-widest block">Completion Date</span>
                                            <p class="font-bold text-slate-700">{{ date('d M, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="fa fa-certificate absolute -right-10 -bottom-10 text-[15rem] text-slate-200/50 rotate-12 pointer-events-none"></i>
                        </div>

                        <!-- Institution Segment -->
                        <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t border-slate-100 gap-8">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-xl">
                                    <i class="fa fa-university text-2xl"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest block mb-1">Authorized Center</span>
                                    <p class="font-black text-slate-900 tracking-tight">{{ strtoupper(optional($user->branch)->branch_name ?? 'GANGAPUR ROAD, NASHIK') }}</p>
                                    <p class="text-xs text-slate-500">Rk Institute - Official Training Provider</p>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-white border border-slate-200 rounded-2xl flex items-center gap-4">
                                <div class="text-right">
                                    <span class="text-slate-400 text-[9px] font-black uppercase tracking-widest block">Official Verification</span>
                                    <p class="text-sm font-black text-indigo-600">www.rklearning.in</p>
                                </div>
                                <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center">
                                    <i class="fa fa-qrcode text-slate-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Background -->
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-50 rounded-full blur-[100px] opacity-60 group-hover:scale-110 transition-transform duration-700"></div>
                </div>
            </div>

            @else
            <!-- Initial State -->
            <div class="p-20 text-center">
                <div class="w-24 h-24 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fa fa-certificate text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">Verify Your Credentials</h3>
                <p class="text-slate-500 max-w-md mx-auto leading-relaxed">
                    Enter the unique certificate identification number provided on the bottom-left of the certificate to verify student details and course completion status.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection