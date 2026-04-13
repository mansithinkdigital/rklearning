@extends('layouts.client')

@section('title', 'Browse Courses - Rk Learning Hub')

@section('content')
<!-- Search & Filter -->
<section class="py-12 bg-white border-b">
    <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
        <h1 class="text-3xl Outfit">Explore All Courses</h1>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:w-80">
                <input type="text" placeholder="Search courses..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
            <button class="bg-slate-100 p-3 rounded-xl text-slate-600 hover:bg-slate-200 transition">
                <i class="fa fa-sliders"></i>
            </button>
        </div>
    </div>
</section>

<!-- Course List -->
<section class="py-16">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <!-- Reuse course card logic, here as static examples -->
            @for ($i = 1; $i <= 8; $i++)
            <div class="course-card">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?q=80&w=2000&auto=format&fit=crop" alt="Course" class="course-img">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="rating-badge"><i class="fa fa-star text-[10px] mr-1"></i> 4.{{ rand(5,9) }}</span>
                        <span class="text-primary font-bold">${{ rand(29, 149) }}.99</span>
                    </div>
                    <h3 class="text-lg mb-3 Outfit line-clamp-2">Premium Course Title {{ $i }} - Modern Skills</h3>
                    <div class="flex items-center text-slate-500 text-[10px] space-x-3 mb-6">
                        <span><i class="fa fa-book-open mr-1"></i> {{ rand(20,50) }} Lessons</span>
                        <span><i class="fa fa-users mr-1"></i> {{ rand(1,9) }}k Students</span>
                    </div>
                    <div class="border-t pt-4">
                        <a href="#" class="btn-primary w-full text-center block py-2 text-sm">Enroll Now</a>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center space-x-2">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border text-slate-600 hover:bg-primary hover:text-white transition">1</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white">2</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border text-slate-600 hover:bg-primary hover:text-white transition">3</a>
            <span class="w-10 h-10 flex items-center justify-center text-slate-400">...</span>
            <hr class="hidden sm:block">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border text-slate-600 hover:bg-primary hover:text-white transition"><i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</section>
@endsection
