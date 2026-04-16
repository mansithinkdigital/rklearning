<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - Learning Player | RK Learning Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #0F172A; color: white; overflow: hidden; }
        .sidebar { width: 400px; height: 100vh; overflow-y: auto; background: #111827; border-l: 1px solid #1f2937; }
        .main-player { flex: 1; height: 100vh; overflow-y: auto; background: #0b0f1a; }
        .subject-container { border-bottom: 1px solid #1f2937; }
        .unit-container { background: #1e293b50; margin: 4px; border-radius: 12px; }
        .topic-item { cursor: pointer; transition: all 0.2s; border-radius: 8px; margin: 2px 8px; }
        .topic-item:hover { background: #334155; }
        .topic-item.active { background: #2563eb; color: white; }
        .material-item { cursor: pointer; transition: all 0.2s; border-radius: 8px; margin: 2px 8px; border: 1px dashed #334155; }
        .material-item:hover { background: #1e293b; border-color: #60a5fa; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0F172A; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>
<body class="flex flex-col md:flex-row h-screen">
    <!-- Main Content Player -->
    <div class="main-player p-6 md:p-10 flex flex-col">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2 text-slate-400 hover:text-white transition group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-bold text-sm">EXIT TO DASHBOARD</span>
            </a>
            <div id="material-header" class="hidden flex items-center gap-4">
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-500/30">Now Viewing</span>
            </div>
        </div>

        <!-- Media Display Area -->
        <div id="player-container" class="aspect-video bg-slate-900 rounded-[2.5rem] overflow-hidden mb-10 shadow-2xl relative border border-slate-800">
            <!-- Default Placeholder -->
            <div id="placeholder-content" class="absolute inset-0 flex flex-col items-center justify-center text-center p-10">
                <div class="w-24 h-24 bg-blue-600/10 rounded-full flex items-center justify-center mb-6 animate-pulse">
                    <i data-lucide="play" class="w-12 h-12 text-blue-500 fill-current"></i>
                </div>
                <h2 class="text-2xl font-black mb-2 uppercase tracking-tight">Select a Topic to Start</h2>
                <p class="text-slate-500 max-w-sm font-medium">Choose a subject and unit from the curriculum sidebar to begin your learning journey.</p>
            </div>

            <!-- Video Player iframe (hidden initially) -->
            <iframe id="video-frame" class="hidden w-full h-full border-none" src="" allow="autoplay; fullscreen" allowfullscreen></iframe>
            
            <!-- PDF Viewer (hidden initially) -->
            <object id="pdf-frame" class="hidden w-full h-full" data="" type="application/pdf">
                <div class="flex flex-col items-center justify-center h-full p-10">
                    <p class="text-slate-400 mb-4">PDF Preview not available</p>
                    <a id="pdf-download-link" href="#" class="px-6 py-3 bg-blue-600 rounded-xl font-bold">Download PDF Instead</a>
                </div>
            </object>
        </div>

        <!-- Content Details Area -->
        <div id="content-details" class="max-w-5xl">
            <div id="text-content" class="hidden">
                <div class="flex items-center gap-3 mb-4">
                    <span id="label-unit" class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-500">Unit 1</span>
                    <span class="text-slate-600">•</span>
                    <span id="label-subject" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Subject Name</span>
                </div>
                <h1 id="content-title" class="text-4xl font-black mb-6 tracking-tight">Select a lesson</h1>
                <div id="content-body" class="text-slate-400 leading-relaxed text-lg space-y-4 font-medium">
                    <!-- Dynamic Content -->
                </div>
            </div>
        </div>
    </div>

    <!-- Hierarchy Sidebar -->
    <aside class="sidebar flex flex-col shadow-2xl">
        <div class="p-8 border-b border-slate-800 bg-[#111827]">
            <h2 class="text-[11px] font-black text-blue-500 uppercase tracking-[0.2em] mb-2">Curriculum</h2>
            <h3 class="text-xl font-black tracking-tight">{{ $course->name }}</h3>
            <div class="mt-6 flex items-center justify-between text-[11px] font-black text-slate-500">
                <span>0% COMPLETE</span>
                <span>{{ $course->subjects->count() }} SUBJECTS</span>
            </div>
            <div class="w-full bg-slate-800 h-1.5 rounded-full mt-2">
                <div class="bg-blue-600 h-1.5 rounded-full w-[2%] shadow-[0_0_10px_rgba(37,99,235,0.5)]"></div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            @foreach($course->subjects as $subject)
            <div class="subject-container">
                <button onclick="toggleSubject({{ $subject->id }})" class="w-full px-8 py-6 flex items-center justify-between hover:bg-slate-800/30 transition-colors text-left group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-slate-800 rounded-2xl flex items-center justify-center text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <i data-lucide="book" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-0.5">Subject</p>
                            <p class="text-sm font-black tracking-tight group-hover:text-blue-400 transition-colors uppercase">{{ $subject->name }}</p>
                        </div>
                    </div>
                    <i data-lucide="chevron-down" id="icon-subject-{{ $subject->id }}" class="w-5 h-5 text-slate-600 transition-transform"></i>
                </button>

                <div id="subject-{{ $subject->id }}" class="hidden pb-2">
                    @foreach($subject->units as $unit)
                    <div class="unit-container">
                        <div class="px-6 py-4 flex items-center gap-3">
                            <i data-lucide="layers" class="w-4 h-4 text-emerald-500"></i>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $unit->name }}</span>
                        </div>
                        
                        <!-- Topics in Unit -->
                        <div class="space-y-1">
                            @foreach($unit->topics as $topic)
                            <div onclick='playTopic(@json($topic), @json($unit), @json($subject))' class="topic-item px-6 py-3 flex items-center gap-4 text-slate-400 hover:text-white">
                                <i data-lucide="file-text" class="w-4 h-4 opacity-50"></i>
                                <span class="text-xs font-bold leading-tight">{{ $topic->name }}</span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Materials in Unit -->
                        <div class="mt-4 p-2 space-y-2">
                            @foreach($unit->paidVideos as $video)
                            <div onclick='playVideo(@json($video), @json($unit), @json($subject))' class="material-item px-4 py-3 bg-blue-600/5 hover:bg-blue-600/10 border-blue-500/20 flex items-center gap-3 text-blue-400 group">
                                <div class="w-8 h-8 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    <i data-lucide="play" class="w-4 h-4 fill-current"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[9px] font-black uppercase tracking-widest opacity-70">Video Class</p>
                                    <p class="text-[11px] font-black tracking-tight leading-none">{{ $video->title }}</p>
                                </div>
                            </div>
                            @endforeach

                            @foreach($unit->freePdfs as $pdf)
                            <div onclick="playPdf('{{ asset('admin/uploads/freepdf/' . $pdf->pdf_file) }}', '{{ $pdf->pdf_name }}', @json($unit), @json($subject))" 
                                class="material-item px-4 py-3 bg-red-600/5 hover:bg-red-600/10 border-red-500/20 flex items-center gap-3 text-red-400 group">
                                <div class="w-8 h-8 rounded-lg bg-red-600/10 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[9px] font-black uppercase tracking-widest opacity-70">PDF Notes</p>
                                    <p class="text-[11px] font-black tracking-tight leading-none">{{ $pdf->pdf_name }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="p-8 border-t border-slate-800 bg-[#0b0f1a]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div>
                    <h5 class="text-sm font-black tracking-tight">Final Assessment</h5>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Locked until 100% completion</p>
                </div>
            </div>
        </div>
    </aside>

    <script>
        lucide.createIcons();

        function toggleSubject(id) {
            const el = document.getElementById(`subject-${id}`);
            const icon = document.getElementById(`icon-subject-${id}`);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                el.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        function resetPlayer() {
            document.getElementById('placeholder-content').classList.add('hidden');
            document.getElementById('video-frame').classList.add('hidden');
            document.getElementById('pdf-frame').classList.add('hidden');
            document.getElementById('text-content').classList.remove('hidden');
            document.getElementById('video-frame').src = '';
        }

        function playTopic(topic, unit, subject) {
            resetPlayer();
            document.getElementById('label-unit').textContent = unit.name;
            document.getElementById('label-subject').textContent = subject.name;
            document.getElementById('content-title').textContent = topic.name;
            document.getElementById('content-body').innerHTML = topic.content ? topic.content : '<p class="italic text-slate-500">No content provided for this topic.</p>';
            
            // Highlight active item
            document.querySelectorAll('.topic-item').forEach(el => el.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }

        function playVideo(video, unit, subject) {
            resetPlayer();
            document.getElementById('video-frame').classList.remove('hidden');
            
            // Transform YouTube URL to embed if needed
            let url = video.video_url;
            if (url.includes('youtube.com/watch?v=')) {
                url = url.replace('watch?v=', 'embed/');
            } else if (url.includes('youtu.be/')) {
                url = url.replace('youtu.be/', 'youtube.com/embed/');
            }
            
            document.getElementById('video-frame').src = url;
            document.getElementById('label-unit').textContent = unit.name;
            document.getElementById('label-subject').textContent = subject.name;
            document.getElementById('content-title').textContent = video.title;
            document.getElementById('content-body').innerHTML = '<p>Video lecture for ' + video.title + '. Please refer to the attached PDF for notes.</p>';
        }

        function playPdf(url, name, unit, subject) {
            resetPlayer();
            document.getElementById('pdf-frame').classList.remove('hidden');
            document.getElementById('pdf-frame').data = url;
            document.getElementById('pdf-download-link').href = url;
            
            document.getElementById('label-unit').textContent = unit.name;
            document.getElementById('label-subject').textContent = subject.name;
            document.getElementById('content-title').textContent = name;
            document.getElementById('content-body').innerHTML = '<p>Reading material for ' + name + '.</p>';
        }
    </script>
</body>
</html>
