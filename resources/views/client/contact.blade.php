@extends('layouts.client')

@section('title', 'Contact Us - Rk Learning Hub')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col lg:flex-row">
            <!-- Contact Info Sidebar -->
            <div class="lg:w-1/3 bg-secondary p-12 lg:p-16 text-white">
                <h2 class="text-3xl Outfit mb-8">Get in Touch</h2>
                <p class="text-slate-400 mb-12">Have questions about our courses or need assistance? Our team is here to help you.</p>
                
                <div class="space-y-8">
                    <div class="flex items-start space-x-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-primary text-xl flex-shrink-0">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-1">Phone</h4>
                            <p class="text-lg">+1 234 567 8900</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-primary text-xl flex-shrink-0">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-1">Email</h4>
                            <p class="text-lg">hello@rk-learning.com</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-primary text-xl flex-shrink-0">
                            <i class="fa fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-1">Address</h4>
                            <p class="text-lg">123 Knowledge St, Suite 400<br>Education District, NY 10001</p>
                        </div>
                    </div>
                </div>

                <div class="mt-20">
                    <h4 class="text-sm font-bold uppercase tracking-widest text-slate-500 mb-6">Follow Us</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-primary rounded-lg flex items-center justify-center transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-primary rounded-lg flex items-center justify-center transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-primary rounded-lg flex items-center justify-center transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:w-2/3 p-12 lg:p-16">
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Full Name</label>
                            <input type="text" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" placeholder="John Doe">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Email Address</label>
                            <input type="email" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" placeholder="john@example.com">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Subject</label>
                        <select class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition bg-white appearance-none">
                            <option>General Inquiry</option>
                            <option>Course Support</option>
                            <option>Partnership</option>
                            <option>Technical Issue</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Message</label>
                        <textarea rows="6" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" placeholder="How can we help you?"></textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full py-4 text-center text-lg">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
