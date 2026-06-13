@extends('layouts.client')
@section('title', 'Help Center - Rk Institute')
@section('content')
    <!-- Hero Section with Search -->
    <section class="bg-indigo-600 py-24 text-white relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
            <div class="absolute -top-10 -left-10 w-64 h-64 rounded-full bg-white blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-80 h-80 rounded-full bg-white blur-3xl"></div>
        </div>

        <div class="container mx-auto px-6 text-center max-w-4xl relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">How can we help you?</h1>
            <p class="text-indigo-100 mb-8 text-lg">Search our knowledge base or browse categories below</p>
            <div class="relative max-w-2xl mx-auto">
                <input type="text" placeholder="Search for answers (e.g., certificates, enrollment...)"
                    class="w-full pl-12 pr-4 py-4 rounded-xl text-white-900 outline-none focus:ring-4 focus:ring-indigo-300 transition-shadow shadow-lg font-medium">
                <i class="fa fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400 text-lg"></i>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-16 -mt-10 relative z-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="#"
                    class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all text-center group border border-slate-100">
                    <div
                        class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fa fa-user-graduate text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">Getting Started</h3>
                    <p class="text-sm text-slate-500">Account setup and enrollment</p>
                </a>

                <a href="#"
                    class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all text-center group border border-slate-100">
                    <div
                        class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fa fa-laptop-code text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">Course Access</h3>
                    <p class="text-sm text-slate-500">Video playback and materials</p>
                </a>

                <a href="{{ route('certificate.verify') }}"
                    class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all text-center group border border-slate-100">
                    <div
                        class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fa fa-certificate text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">Certificates</h3>
                    <p class="text-sm text-slate-500">Downloading and verifying</p>
                </a>

                <a href="#"
                    class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all text-center group border border-slate-100">
                    <div
                        class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fa fa-credit-card text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">Payments</h3>
                    <p class="text-sm text-slate-500">Billing, refunds, and receipts</p>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQs -->
    <section class="py-16 bg-slate-60">
        <div class="container mx-auto px-6 max-w-7xl">
            <h2 class="text-3xl font-bold text-slate-900 mb-10 text-center">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-slate-900 text-lg mb-2">How do I verify my certificate?</h4>
                    <p class="text-slate-600">You can verify your certificate by going to the 'Verify Certificate' page from
                        the main menu and entering your unique certificate ID provided on the bottom left of your
                        certificate.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-slate-900 text-lg mb-2">How long do I have access to a course?</h4>
                    <p class="text-slate-600">Once enrolled, you typically have lifetime access to the course materials,
                        including any future updates to the course content.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-slate-900 text-lg mb-2">Who can I contact if I face technical issues?</h4>
                    <p class="text-slate-600">You can reach out to our support team at Rkinstitute2026@gmail.com or call us
                        at +91 8888937680 during our working hours.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support -->
    <section class="py-20">
        <div class="container mx-auto px-6 text-center max-w-2xl">
            <div
                class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                <i class="fa fa-headset"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 mb-6">Still need help?</h2>
            <p class="text-slate-600 mb-8">Our support team is always ready to help you with any issues you might be facing.
            </p>
            <a href="{{ route('contact') }}" class="btn-join px-8 py-3 inline-block shadow-lg hover:shadow-xl">Contact
                Support</a>
        </div>
    </section>
@endsection
