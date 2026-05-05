<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - Academic Player | RK Learning Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            overflow: hidden;
        }

        .sidebar {
            width: 420px;
            height: 100vh;
            overflow-y: auto;
            background: #ffffff;
            border-left: 1px solid #e2e8f0;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.02);
            z-index: 50;
        }

        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                right: -420px;
                transition: right 0.3s ease;
            }

            .sidebar.active {
                right: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 40;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        .main-player {
            flex: 1;
            height: 100vh;
            overflow-y: auto;
            background: #f8fafc;
        }

        .subject-container {
            border-bottom: 1px solid #f1f5f9;
        }

        .unit-card {
            background: #f8fafc;
            margin: 8px 12px;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .unit-card:hover {
            border-color: #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .topic-link {
            cursor: pointer;
            transition: all 0.2s;
            border-radius: 12px;
            margin: 2px 8px;
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.825rem;
        }

        .topic-link:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .topic-link.active {
            background: #2563eb;
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
        }

        .material-link {
            cursor: pointer;
            transition: all 0.2s;
            border-radius: 16px;
            margin: 4px 8px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1.5px dashed #e2e8f0;
        }

        .material-link:hover {
            background: #ffffff;
            border-color: #2563eb;
            border-style: solid;
            transform: translateY(-1px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #f1f5f9;
        }

        /* Toast Notification */
        #custom-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #0f172a;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        #custom-toast.show {
            transform: translateX(-50%) translateY(0);
        }
    </style>
</head>

<body class="flex flex-col md:flex-row h-screen">
    <!-- Main Content Player -->
    <div class="main-player flex flex-col">
        <!-- Header -->
        <header class="glass-header px-6 md:px-10 py-5 flex items-center justify-between sticky top-0 z-20">
            <div class="flex items-center gap-4 md:gap-6">
                <a href="{{ route('student.dashboard') }}" class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-all bg-slate-50 px-3 md:px-4 py-2.5 rounded-xl border border-slate-100">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
                <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>
                <div id="material-indicator" class="hidden flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">Active Session</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2.5 rounded-xl text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 p-0.5">
                    <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                        <img src="{{ $user->image ? asset($user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <div class="p-6 md:p-10 flex-1">
            <!-- Media Display Area -->
            <div id="player-container" class="aspect-video bg-slate-900 rounded-2xl md:rounded-[3rem] overflow-hidden mb-8 md:mb-12 shadow-2xl relative ring-4 md:ring-8 ring-white">
                <!-- Loader -->
                <div id="player-loader" class="hidden absolute inset-0 z-30 flex flex-col items-center justify-center bg-slate-900/90 backdrop-blur-sm">
                    <div class="relative">
                        <div class="w-16 h-16 border-4 border-blue-500/20 border-t-blue-500 rounded-full animate-spin"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i data-lucide="play" class="w-6 h-6 text-blue-500 fill-blue-500 animate-pulse"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-xs font-black uppercase tracking-[0.2em] text-blue-400 animate-pulse">Initializing Media...</p>
                </div>

                <!-- YouTube/Video State -->
                <div id="video-frame" class="hidden w-full h-full"></div>

                <!-- PDF State -->
                <object id="pdf-frame" class="hidden w-full h-full" data="" type="application/pdf">
                    <div class="flex flex-col items-center justify-center h-full p-20 text-center text-white">
                        <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center mb-6">
                            <i data-lucide="file-warning" class="w-10 h-10 text-slate-500"></i>
                        </div>
                        <h4 class="font-black uppercase tracking-widest text-sm mb-4">PDF Preview Unavailable</h4>
                        <a id="pdf-download-link" href="#" class="px-8 py-4 bg-blue-600 rounded-2xl text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-blue-500/20 hover:scale-105 transition-all">Download Reference</a>
                    </div>
                </object>
                <!-- Welcome State -->
                <div id="placeholder-content" class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 md:p-20 bg-gradient-to-br from-slate-900 to-indigo-950">
                    <div class="relative mb-6 md:mb-10">
                        <div class="absolute inset-0 bg-blue-500 rounded-full blur-[80px] opacity-20 animate-pulse"></div>
                        <div class="relative w-20 h-20 md:w-28 md:h-28 bg-white/5 rounded-full flex items-center justify-center border border-white/10 backdrop-blur-3xl">
                            <i data-lucide="play" class="w-8 h-8 md:w-12 md:h-12 text-blue-400 fill-blue-400/20"></i>
                        </div>
                    </div>
                    <h2 class="text-xl md:text-3xl font-black text-white mb-4 uppercase tracking-tighter">Ready to Learn?</h2>
                    <p class="text-slate-400 max-w-sm font-bold text-[10px] md:text-[11px] uppercase tracking-[0.2em] leading-loose opacity-70">Pick a module from the curriculum catalog to launch the learning interface.</p>
                </div>
            </div>

            <!-- Content Info Area -->
            <div id="content-details" class="max-w-4xl mx-auto hidden animate-in slide-in-from-bottom-5 duration-700">
                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
                    <div id="type-icon-box" class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shrink-0">
                        <i data-lucide="book-open" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <span id="label-subject" class="text-[9px] font-black uppercase tracking-widest text-slate-400 tracking-[0.2em]">General Subject</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span id="label-unit" class="text-[9px] font-black uppercase tracking-widest text-blue-500 tracking-[0.2em]">Introductory Unit</span>
                        </div>
                        <h1 id="content-title" class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight leading-tight uppercase">Lesson Header</h1>
                    </div>
                </div>
                <div class="bg-white rounded-3xl md:rounded-[2.5rem] p-6 md:p-14 border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-20"></div>
                    <div id="content-body" class="prose prose-slate max-w-none text-slate-600 font-medium leading-relaxed prose-sm md:prose-base">
                        <!-- Summernote content will render here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum Sidebar -->
    <aside class="sidebar flex flex-col">
        <!-- Sidebar Branding -->
        <div class="p-10 border-b border-slate-100">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-slate-900">RK Learning Hub</span>
            </div>

            <h3 class="text-xl font-black tracking-tight text-slate-900 mb-6">{{ $course->name }}</h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                    <span class="text-slate-400">Course Momentum</span>
                    <span class="text-blue-600">Dynamic Curriculum</span>
                </div>

                <div class="space-y-4 mt-2">
                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                        <span class="text-slate-400">Course Progress</span>
                        <span id="progress-percent" class="text-blue-600">0%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div id="course-progress-bar" class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Catalog Items -->
            <div class="flex-1 overflow-y-auto custom-scrollbar pt-4">
                @foreach($course->subjects as $subject)
                <div class="subject-container">
                    <button onclick="toggleSubject({{ $subject->id }}, this)" class="w-full px-10 py-6 flex items-center justify-between hover:bg-slate-50 transition-all text-left group {{ $loop->first ? 'bg-blue-50/50' : '' }}">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:bg-white group-hover:border-blue-200 group-hover:text-blue-600 transition-all shadow-sm">
                                <i data-lucide="layers" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Subject</p>
                                <p class="text-[14px] font-black tracking-tight text-slate-700 leading-none uppercase">{{ $subject->name }}</p>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 transition-transform duration-300" style="{{ $loop->first ? 'transform: rotate(90deg)' : '' }}"></i>
                    </button>

                    <div id="subject-{{ $subject->id }}" class="{{ $loop->first ? '' : 'hidden' }} overflow-hidden transition-all duration-500 bg-white">
                        @foreach($subject->units as $unit)
                        <div class="unit-card p-2">
                            <div class="px-6 py-4 flex items-center gap-3">
                                <div class="w-1.5 h-4 bg-emerald-500/20 rounded-full border border-emerald-500/50"></div>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest tracking-[0.2em]">{{ $unit->name }}</span>
                            </div>

                            <!-- List Content -->
                            <div class="space-y-1 pb-4">
                                @foreach($unit->topics as $topic)
                                @if($topic->video_id)
                                @php
                                $dbId = $topic->id + 1000000;
                                $isCompleted = in_array($dbId, $completedVideoIds);
                                $videoIndex = $allVideos->search(fn($v) => isset($v->db_id) && $v->db_id == $dbId);
                                $isUnlocked = ($videoIndex === 0) || ($videoIndex !== false && in_array($allVideos[$videoIndex-1]->db_id, $completedVideoIds));
                                @endphp
                                <div id="vid-{{ $dbId }}"
                                    data-video='@json($topic)'
                                    data-unit='@json($unit)'
                                    data-subject='@json($subject)'
                                    onclick='handleTopicClick(this, @json($topic), @json($unit), @json($subject), {{ $dbId }}); closeSidebarMobile();'
                                    class="material-link group {{ $isUnlocked ? 'bg-indigo-50/30 border-indigo-100 text-indigo-600 hover:bg-indigo-50' : 'bg-slate-50 border-slate-100 text-slate-400 cursor-not-allowed opacity-60' }}">
                                    <div class="flex items-center gap-4 flex-1 overflow-hidden">
                                        <div class="relative w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $isCompleted ? 'bg-emerald-100 text-emerald-600' : ($isUnlocked ? 'bg-white text-indigo-400 shadow-sm' : 'bg-slate-200 text-slate-400') }}">
                                            @if($isCompleted)
                                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                            @elseif($isUnlocked)
                                            <i data-lucide="play" class="w-3.5 h-3.5 ml-0.5"></i>
                                            <div class="absolute inset-0 border border-indigo-200 rounded-full scale-110 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all"></div>
                                            @else
                                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block truncate text-[11px] font-bold">{{ $topic->name }}</span>
                                            <span class="block text-[9px] uppercase tracking-widest mt-0.5 {{ $isUnlocked ? 'text-indigo-400' : 'text-slate-400' }}">Video Lesson</span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div onclick='playTopic(@json($topic), @json($unit), @json($subject)); closeSidebarMobile();' class="topic-link group">
                                    <i data-lucide="dot" class="w-4 h-4 mr-3 text-slate-300 group-hover:text-blue-500"></i>
                                    <span class="flex-1 truncate">{{ $topic->name }}</span>
                                </div>
                                @endif
                                @endforeach
                                @foreach($unit->paidVideos as $video)
                                @php
                                $dbId = $video->id;
                                $isCompleted = in_array($dbId, $completedVideoIds);
                                $videoIndex = $allVideos->search(fn($v) => isset($v->db_id) && $v->db_id == $dbId);
                                $isUnlocked = ($videoIndex === 0) || ($videoIndex !== false && in_array($allVideos[$videoIndex-1]->db_id, $completedVideoIds));
                                @endphp
                                <div id="vid-{{ $dbId }}"
                                    data-video='@json($video)'
                                    data-unit='@json($unit)'
                                    data-subject='@json($subject)'
                                    onclick='handleVideoClick(this, {{ $dbId }}); closeSidebarMobile();'
                                    class="material-link group {{ $isUnlocked ? 'bg-indigo-50/30 border-indigo-100 text-indigo-600 hover:bg-indigo-50' : 'bg-slate-50 border-slate-100 text-slate-400 cursor-not-allowed opacity-60' }}">
                                    <div class="w-8 h-8 rounded-xl {{ $isUnlocked ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-400' }} flex items-center justify-center group-hover:scale-110 transition-all">
                                        @if($isCompleted)
                                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                                        @elseif(!$isUnlocked)
                                        <i data-lucide="lock" class="w-4 h-4"></i>
                                        @else
                                        <i data-lucide="play" class="w-4 h-4 fill-current"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 py-1">
                                        <p class="text-[9px] font-black uppercase tracking-widest leading-none mb-1 opacity-70">
                                            {{ $isCompleted ? 'Completed' : ($isUnlocked ? 'Play Video' : 'Locked') }}
                                        </p>
                                        <p class="text-[12px] font-black tracking-tight truncate">{{ $video->title }}</p>
                                    </div>
                                </div>
                                @endforeach

                                @foreach($unit->freePdfs as $pdf)
                                <div onclick="playPdf('{{ asset('admin/uploads/freepdf/' . $pdf->pdf_file) }}', '{{ $pdf->pdf_name }}', @json($unit), @json($subject)); closeSidebarMobile();"
                                    class="material-link group bg-emerald-50/30 border-emerald-100 text-emerald-600 hover:bg-emerald-50">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700 group-hover:scale-110 transition-all">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 py-1">
                                        <p class="text-[9px] font-black uppercase tracking-widest leading-none mb-1 opacity-70">Read Notes</p>
                                        <p class="text-[12px] font-black tracking-tight truncate">{{ $pdf->pdf_name }}</p>
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

            <!-- Footer -->
            <div id="sidebar-footer" class="p-10 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div id="exam-unlock-icon" class="w-12 h-12 bg-slate-200 text-slate-400 rounded-2xl flex items-center justify-center transition-all duration-500">
                        <i data-lucide="lock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h5 id="exam-unlock-title" class="text-sm font-black tracking-tight text-slate-800">Exam Locked</h5>
                        <p id="exam-unlock-subtitle" class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Complete all videos to unlock</p>
                    </div>
                </div>
            </div>
    </aside>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        lucide.createIcons();
        // ─── STATE ───────────────────────────────────────────
        let player = null;
        let currentVideoId = null;
        let currentVideoIdDB = null;
        let furthestTime = 0;
        let seekCheckInterval = null;
        const ALL_VIDEOS = @json($allVideos);
        let COMPLETED_VIDS = @json($completedVideoIds);
        const COURSE_ID = @json($course->id);
        // ─── YOUTUBE API ─────────────────────────────────────
        function onYouTubeIframeAPIReady() {
            // Player will be initialized when playVideo is called
        }

        function initPlayer(youtubeId) {
            furthestTime = 0;
            if (seekCheckInterval) clearInterval(seekCheckInterval);

            if (player) {
                document.getElementById('player-loader').classList.add('hidden');
                document.getElementById('video-frame').classList.remove('hidden');
                player.loadVideoById(youtubeId);
                return;
            }
            player = new YT.Player('video-frame', {
                height: '100%',
                width: '100%',
                videoId: youtubeId,
                playerVars: {
                    'autoplay': 1,
                    'rel': 0,
                    'modestbranding': 1,
                    'controls': 1 // Keep controls but manage seeking
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            document.getElementById('player-loader').classList.add('hidden');
            document.getElementById('video-frame').classList.remove('hidden');
            startSeekCheck();
        }

        function startSeekCheck() {
            if (seekCheckInterval) clearInterval(seekCheckInterval);
            seekCheckInterval = setInterval(() => {
                if (player && player.getPlayerState() === YT.PlayerState.PLAYING) {
                    const currentTime = player.getCurrentTime();

                    // Allow seeking: just update furthest time so completion check still passes
                    furthestTime = Math.max(furthestTime, currentTime);
                }
            }, 1000);
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.ENDED) {
                // Since seeking is allowed, mark as completed directly when video ends
                markAsCompleted(currentVideoIdDB);
            }
        }

        function showToast(msg) {
            const toast = document.getElementById('custom-toast');
            toast.querySelector('.toast-msg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // ─── CORE LOGIC ──────────────────────────────────────
        function toggleSubject(id, btn) {
            const el = document.getElementById(`subject-${id}`);
            const icon = btn.querySelector('i[data-lucide="chevron-right"]');
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                btn.classList.add('bg-blue-50/50');
                if (icon) icon.style.transform = 'rotate(90deg)';
            } else {
                el.classList.add('hidden');
                btn.classList.remove('bg-blue-50/50');
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        }

        function resetPlayer(type = 'text') {
            document.getElementById('placeholder-content').classList.add('hidden');
            document.getElementById('video-frame').classList.add('hidden');
            document.getElementById('pdf-frame').classList.add('hidden');
            document.getElementById('content-details').classList.remove('hidden');
            document.getElementById('material-indicator').classList.remove('hidden');

            if (type === 'video' || type === 'pdf') {
                document.getElementById('player-loader').classList.remove('hidden');
            } else {
                document.getElementById('player-loader').classList.add('hidden');
                if (player) player.stopVideo();
            }

            const typeIconBox = document.getElementById('type-icon-box');
            if (type === 'video') {
                typeIconBox.className = 'w-12 h-12 rounded-2xl flex items-center justify-center text-white bg-red-600 shadow-xl shadow-red-500/20';
                typeIconBox.innerHTML = '<i data-lucide="youtube" class="w-6 h-6"></i>';
            } else if (type === 'pdf') {
                typeIconBox.className = 'w-12 h-12 rounded-2xl flex items-center justify-center text-white bg-emerald-600 shadow-xl shadow-emerald-500/20';
                typeIconBox.innerHTML = '<i data-lucide="file-text" class="w-6 h-6"></i>';
            } else {
                typeIconBox.className = 'w-12 h-12 rounded-2xl flex items-center justify-center text-white bg-blue-600 shadow-xl shadow-blue-500/20';
                typeIconBox.innerHTML = '<i data-lucide="book-open" class="w-6 h-6"></i>';
            }
            lucide.createIcons();
        }

        function playVideo(video, unit, subject, dbId) {
            resetPlayer('video');
            currentVideoIdDB = dbId;
            const input = video.video_id || video.video_url;
            const youtubeId = extractYouTubeVideoId(input);
            if (youtubeId) {
                currentVideoId = youtubeId;
                initPlayer(youtubeId);
            } else {
                alert("Invalid Video Source");
                document.getElementById('player-loader').classList.add('hidden');
            }
            document.getElementById('label-unit').textContent = unit.name;
            document.getElementById('label-subject').textContent = subject.name;
            document.getElementById('content-title').textContent = video.name || video.title;
            document.getElementById('content-body').innerHTML = '<div class="py-10 text-center"><p class="text-slate-500 font-bold uppercase tracking-widest text-[11px] mb-4">Class in Session</p><p class="text-slate-400 text-sm max-w-xs mx-auto">Please watch the entire video to mark this module as completed and unlock the next lesson.</p></div>';
            // Highlight
            document.querySelectorAll('.material-link').forEach(el => el.classList.remove('active', 'ring-2', 'ring-blue-500'));
            const currentEl = document.getElementById(`vid-${dbId}`);
            if (currentEl) currentEl.classList.add('ring-2', 'ring-blue-500');
        }

        function markAsCompleted(dbId) {
            if (COMPLETED_VIDS.includes(dbId)) return;
            $.ajax({
                url: `/student/videos/${dbId}/complete`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        COMPLETED_VIDS.push(dbId);
                        updateProgressUI();
                        unlockNextVideo(dbId);
                    }
                },
                error: function(err) {
                    console.error("Failed to mark video as completed", err);
                }
            });
        }

        function updateProgressUI() {
            const total = ALL_VIDEOS.length;
            const completed = COMPLETED_VIDS.length;
            const pct = Math.round((completed / total) * 100);
            document.getElementById('course-progress-bar').style.width = pct + '%';
            document.getElementById('progress-percent').textContent = pct + '%';
            if (pct >= 100) {
                const iconBox = document.getElementById('exam-unlock-icon');
                iconBox.className = 'w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-600/20';
                iconBox.innerHTML = '<i data-lucide="award" class="w-6 h-6"></i>';
                document.getElementById('exam-unlock-title').textContent = 'Exam Unlocked!';
                document.getElementById('exam-unlock-subtitle').innerHTML = '<a href="{{ route("student.exams") }}" class="text-blue-600 hover:underline">Click here to start assessment</a>';

                // Also update footer to be a link
                const footer = document.getElementById('sidebar-footer');
                footer.className = 'p-10 border-t border-slate-100 bg-emerald-50/30 cursor-pointer hover:bg-emerald-50 transition-colors';
                footer.onclick = () => window.location.href = "{{ route('student.exams') }}";
                lucide.createIcons();
            }
        }

        function handleVideoClick(el, dbId) {
            if (el.classList.contains('cursor-not-allowed')) {
                showLockedMsg();
                return;
            }
            const video = JSON.parse(el.getAttribute('data-video'));
            const unit = JSON.parse(el.getAttribute('data-unit'));
            const subject = JSON.parse(el.getAttribute('data-subject'));
            playVideo(video, unit, subject, dbId);
        }

        function unlockNextVideo(currentDbId) {
            const currentIndex = ALL_VIDEOS.findIndex(v => v.db_id == currentDbId);
            // Mark current as done visually
            const currentEl = document.getElementById(`vid-${currentDbId}`);
            if (currentEl) {
                const iconBox = currentEl.querySelector('.w-8.h-8');
                if (iconBox) {
                    iconBox.innerHTML = '<i data-lucide="check-circle-2" class="w-4 h-4"></i>';
                    iconBox.className = 'relative w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-emerald-100 text-emerald-600';
                }
                const label = currentEl.querySelector('.tracking-widest.mt-0\\.5');
                if (label) label.textContent = 'Completed';
            }

            if (currentIndex >= 0 && currentIndex < ALL_VIDEOS.length - 1) {
                const nextVideo = ALL_VIDEOS[currentIndex + 1];
                const nextEl = document.getElementById(`vid-${nextVideo.db_id}`);
                if (nextEl) {
                    nextEl.classList.remove('bg-slate-50', 'border-slate-100', 'text-slate-400', 'cursor-not-allowed', 'opacity-60');
                    nextEl.classList.add('bg-indigo-50/30', 'border-indigo-100', 'text-indigo-600', 'hover:bg-indigo-50');
                    const iconBox = nextEl.querySelector('.w-8.h-8');
                    if (iconBox) {
                        iconBox.className = 'relative w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-white text-indigo-400 shadow-sm';
                        iconBox.innerHTML = '<i data-lucide="play" class="w-3.5 h-3.5 ml-0.5"></i><div class="absolute inset-0 border border-indigo-200 rounded-full scale-110 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all"></div>';
                    }
                    const label = nextEl.querySelector('.tracking-widest.mt-0\\.5');
                    if (label) {
                        label.classList.remove('text-slate-400');
                        label.classList.add('text-indigo-400');
                        label.textContent = 'Video Lesson';
                    }
                }
            }
            lucide.createIcons();
        }
        function showLockedMsg() {
            alert("🔒 Lesson Locked: Please complete the previous video lessons in sequence to unlock this module.");
        }

        function extractYouTubeVideoId(url) {
            if (!url) return null;
            if (url.length === 11 && !url.includes('http')) return url;
            try {
                const parsed = new URL(url);
                if (parsed.hostname.includes('youtube.com')) return parsed.searchParams.get('v');
                if (parsed.hostname === 'youtu.be') return parsed.pathname.slice(1);
            } catch (e) {
                return null;
            }
            return null;
        }

        function handleTopicClick(el, topic, unit, subject, dbId) {
            if (el.classList.contains('cursor-not-allowed')) {
                showLockedMsg();
                return;
            }
            playTopic(topic, unit, subject, dbId);
        }

        function playTopic(topic, unit, subject, dbId = null) {
            if (topic.video_id) {
                // Topic is a video, check if it's the current "unlocked" one or already done
                const vidDbId = dbId || (topic.id + 1000000);
                const el = document.getElementById(`vid-${vidDbId}`);
                if (el && el.classList.contains('cursor-not-allowed')) {
                    showLockedMsg();
                    return;
                }
                playVideo(topic, unit, subject, vidDbId);
            } else if (topic.study_material) {
                const materialPath = `{{ asset('admin/uploads/material/') }}/${topic.study_material}`;
                playPdf(materialPath, `Notes: ${topic.name}`, unit, subject);
            } else {
                resetPlayer('text');
                document.getElementById('label-unit').textContent = unit.name;
                document.getElementById('label-subject').textContent = subject.name;
                document.getElementById('content-title').textContent = topic.name;
                document.getElementById('content-body').innerHTML = topic.content ? topic.content : '<div class="py-20 text-center"><p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">No textual curriculum defined for this module.</p></div>';
            }
            document.querySelectorAll('.topic-link').forEach(el => el.classList.remove('active'));
            if (window.event && window.event.currentTarget) window.event.currentTarget.classList.add('active');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function playPdf(url, name, unit, subject) {
            resetPlayer('pdf');
            document.getElementById('pdf-frame').classList.remove('hidden');
            document.getElementById('pdf-frame').data = url;
            document.getElementById('pdf-download-link').href = url;
            document.getElementById('label-unit').textContent = unit.name;
            document.getElementById('label-subject').textContent = subject.name;
            document.getElementById('content-title').textContent = name;
            document.getElementById('content-body').innerHTML = '<div class="py-10"><p class="text-slate-500">Academic reference material active. If the PDF does not display above, please use the download button inside the player area.</p></div>';
        }

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }

        function closeSidebarMobile() {
            if (window.innerWidth < 1024) {
                document.querySelector('.sidebar').classList.remove('active');
                document.querySelector('.sidebar-overlay').classList.remove('active');
            }
        }

        // Initialize Progress and Auto-play on load
        document.addEventListener('DOMContentLoaded', () => {
            updateProgressUI();
            
            // Auto-play first video if available and unlocked
            const firstVideoLink = document.querySelector('.material-link:not(.cursor-not-allowed)[data-video]');
            if (firstVideoLink) {
                // Small delay to ensure UI and Lucide icons are ready
                setTimeout(() => {
                    firstVideoLink.click();
                }, 500);
            }
        });
    </script>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Toast Notification -->
    <div id="custom-toast">
        <i data-lucide="alert-circle" class="w-4 h-4 text-amber-400"></i>
        <span class="toast-msg"></span>
    </div>
</body>

</html>