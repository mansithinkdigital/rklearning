<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Player - RK Learning Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #0F172A; color: white; overflow: hidden; }
        .sidebar { width: 350px; height: 100vh; overflow-y: auto; background: #1E293B; border-l: 1px solid #334155; }
        .main-player { flex: 1; height: 100vh; overflow-y: auto; }
        .chapter-item { cursor: pointer; border-bottom: 1px solid #334155; transition: all 0.2s; }
        .chapter-item:hover { background: #334155; }
        .chapter-item.active { background: #1D4ED8; color: white; }
    </style>
</head>
<body class="flex flex-col md:flex-row h-screen">
    <!-- Main Content Player -->
    <div class="main-player p-6 md:p-10 flex flex-col">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2 text-slate-400 hover:text-white transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span class="font-bold">Back to Dashboard</span>
            </a>
            <div class="flex space-x-4">
                <button class="px-5 py-2 bg-slate-800 rounded-lg font-medium text-sm hover:bg-slate-700">Next Lesson &rarr;</button>
            </div>
        </div>

        <!-- Video Player -->
        <div class="aspect-video bg-black rounded-3xl overflow-hidden mb-8 shadow-2xl relative">
            <div class="absolute inset-0 flex items-center justify-center">
                <p class="text-slate-500 font-bold uppercase tracking-widest italic">Video Lecture Placeholder</p>
                <i data-lucide="play-circle" class="w-16 h-16 text-white/20 absolute"></i>
            </div>
            <!-- In Production: <iframe src="..." class="w-full h-full"></iframe> -->
        </div>

        <!-- Content Details -->
        <div class="max-w-4xl">
            <h1 class="text-3xl font-bold mb-4">Chapter 4: Advanced Journal Entries</h1>
            <p class="text-slate-400 leading-relaxed mb-10">
                In this video, we dive deep into complex journal vouchers, bank reconciliations, and GST adjustments in Tally Prime. Make sure to download the worksheet before starting.
            </p>

            <!-- Resources -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-slate-800 rounded-2xl flex items-center justify-between border border-slate-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center text-blue-400"><i data-lucide="file-text"></i></div>
                        <div>
                            <p class="text-sm font-bold">Exercise_1.pdf</p>
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter">1.2 MB</p>
                        </div>
                    </div>
                    <a href="#" class="p-2 hover:bg-slate-700 rounded-lg transition text-slate-400 hover:text-white"><i data-lucide="download" class="w-5 h-5"></i></a>
                </div>
                <div class="p-4 bg-slate-800 rounded-2xl flex items-center justify-between border border-slate-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center text-emerald-400"><i data-lucide="help-circle"></i></div>
                        <div>
                            <p class="text-sm font-bold">Chapter Quiz</p>
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter">5 Questions</p>
                        </div>
                    </div>
                    <a href="#" class="p-2 hover:bg-slate-700 rounded-lg transition text-slate-400 hover:text-white"><i data-lucide="external-link" class="w-5 h-5"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter Sidebar -->
    <aside class="sidebar p-6 flex flex-col">
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-1">Course Content</h2>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Professional Tally Prime</p>
            <div class="w-full bg-slate-700 h-1 rounded-full mt-4">
                <div class="bg-blue-600 h-1 rounded-full w-[45%]"></div>
            </div>
        </div>

        <div class="space-y-1">
            <div class="chapter-item p-4 rounded-xl active flex items-center space-x-3">
                <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                <div class="flex-1">
                    <p class="text-xs font-bold uppercase tracking-tighter opacity-70">Current Lesson</p>
                    <p class="text-sm font-bold">4. Advanced Journal Entries</p>
                </div>
                <i data-lucide="play" class="w-4 h-4 opacity-50"></i>
            </div>

            <div class="chapter-item p-4 rounded-xl flex items-center space-x-3 text-slate-400">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center"><i data-lucide="check" class="w-4 h-4"></i></div>
                <div class="flex-1">
                    <p class="text-sm font-medium">1. Introduction to Tally</p>
                </div>
            </div>

            <div class="chapter-item p-4 rounded-xl flex items-center space-x-3 text-slate-400">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center"><i data-lucide="check" class="w-4 h-4"></i></div>
                <div class="flex-1">
                    <p class="text-sm font-medium">2. Setting up Ledger</p>
                </div>
            </div>

            <div class="chapter-item p-4 rounded-xl flex items-center space-x-3 text-slate-400">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center"><i data-lucide="check" class="w-4 h-4"></i></div>
                <div class="flex-1">
                    <p class="text-sm font-medium">3. Basic Voucher Entries</p>
                </div>
            </div>

            <div class="chapter-item p-4 rounded-xl flex items-center space-x-3 opacity-50">
                <div class="w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center"><i data-lucide="lock" class="w-4 h-4"></i></div>
                <div class="flex-1">
                    <p class="text-sm font-medium">5. Final Reports & GST</p>
                </div>
            </div>
            
            <div class="pt-10">
                <div class="card bg-slate-800/50 border-slate-700 p-6 text-center">
                    <i data-lucide="award" class="w-10 h-10 text-yellow-500 mx-auto mb-4"></i>
                    <h5 class="font-bold mb-2">Final Exam</h5>
                    <p class="text-xs text-slate-500 mb-4">You must complete all chapters to unlock the final examination.</p>
                    <button disabled class="w-full py-2 bg-slate-700 rounded-lg text-slate-500 font-bold text-xs cursor-not-allowed">Locked</button>
                </div>
            </div>
        </div>
    </aside>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
