@extends('admin.layouts.main')

@section('title', 'Topic Management')

@section('content')
<div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <div class="flex items-center gap-2 mb-2">
            @if(isset($unit))
            <a href="{{ route('admin.course.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">
                {{ $unit->subject->course->name }}
            </a>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
            <a href="{{ route('admin.subject.index', ['course_id' => $unit->subject->course_id]) }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">
                {{ $unit->subject->name }}
            </a>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">{{ $unit->name }}</span>
            @endif
        </div>
        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2 uppercase">
            @if(isset($unit))
                {{ $unit->name }} <span class="text-indigo-600">Topics</span>
            @else
                TOPICS REPOSITORY
            @endif
        </h1>
        <p class="text-sm font-bold text-slate-400 dark:text-slate-500">
            @if(isset($unit))
                Detail out your curriculum with specific lessons and topics
            @else
                Manage academic topics and their parent units
            @endif
        </p>
    </div>
    @if(isset($unit))
    <a href="{{ route('admin.subject.units.index', $unit->subject_id) }}" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-left" class="w-3 h-3"></i>
        Unit Structure
    </a>
    @endif
</div>

<!-- Custom Alert Container -->
<div id="alertContainer" class="hidden mb-6">
    <div id="alertBox" class="p-5 rounded-[1.5rem] flex items-center justify-between border">
        <div class="flex items-center gap-4">
            <div id="alertIcon" class="w-10 h-9 rounded-xl flex items-center justify-center">
                <i data-lucide="info" class="w-5 h-5"></i>
            </div>
            <div>
                <p id="alertTitle" class="text-[11px] font-black uppercase tracking-widest leading-tight mb-0.5"></p>
                <p id="alertMessage" class="text-sm font-bold opacity-80"></p>
            </div>
        </div>
        <button onclick="hideAlert()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>

<div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-8 bg-indigo-600 rounded-full"></div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                @if(isset($unit))
                    Unit Topics
                @else
                    Curriculum Topics
                @endif
            </h2>
        </div>
        <div class="flex items-center gap-4">
            @if(isset($unit))
            <a href="{{ route('admin.topic.index') }}" class="px-6 py-4 rounded-2xl border border-slate-100 dark:border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-50 transition-all">
                Show All Topics
            </a>
            @endif
            <button onclick="openTopicModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-indigo-200 dark:shadow-none flex items-center gap-3">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Add New Topic
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Order</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Topic Name</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Parent Unit</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($topics as $topic)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/10 transition-colors group">
                    <td class="px-10 py-8 text-sm font-black text-slate-400">
                        {{ $topic->order }}
                    </td>
                    <td class="px-10 py-8">
                        <p class="text-[13px] font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $topic->name }}</p>
                    </td>
                    <td class="px-10 py-8">
                        <span class="text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                            {{ $topic->unit->name }} ({{ $topic->unit->subject->name }})
                        </span>
                    </td>
                    <td class="px-10 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editTopic({{ $topic->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteTopic({{ $topic->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-red-600 dark:hover:text-red-400 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="book-open" class="w-12 h-12 text-slate-200 dark:text-slate-800"></i>
                            <p class="text-sm font-bold text-slate-400">No topics found. Add some lessons to this unit!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Topic Modal -->
<div id="topicModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-[#0b1120] w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Add New Topic</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Configure topic details</p>
                </div>
                <button onclick="closeTopicModal()" class="w-12 h-12 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white rounded-2xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="topicForm" class="p-8 lg:p-10">
                @csrf
                <input type="hidden" id="topic_id_pk" name="id">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Parent Unit -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Parent Unit <span class="text-red-600">*</span></label>
                        @if(isset($unit))
                            <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                            <div class="w-full bg-slate-100 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-500">
                                {{ $unit->name }} ({{ $unit->subject->name }})
                            </div>
                        @else
                            <select name="unit_id" id="unit_id" required
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all appearance-none cursor-pointer">
                                <option value="">Select Unit</option>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->subject->name }})</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <!-- Topic Name -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Topic Name <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="topic_name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                            placeholder="e.g. 1.1 First Principles">
                    </div>

                    <!-- YouTube Video Link -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">YouTube Video Link</label>
                        <div class="relative">
                            <i data-lucide="youtube" class="absolute left-6 top-1/2 -translate-y-1/2 w-4 h-4 text-red-500"></i>
                            <input type="url" name="video_url" id="topic_video_url"
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl pl-14 pr-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"
                                placeholder="Paste YouTube link (Watch or Embed)">
                        </div>
                        
                        <!-- Video Preview Card -->
                        <div id="video_preview_container" class="mt-4 hidden animate-in fade-in slide-in-from-top-2 duration-500">
                            <div class="relative rounded-2xl overflow-hidden aspect-video border-2 border-slate-100 group">
                                <img id="video_thumbnail" src="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-red-600 shadow-xl">
                                        <i data-lucide="play" class="w-6 h-6 fill-current"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <span class="px-2 py-1 bg-black/60 backdrop-blur-md text-[9px] font-black text-white uppercase tracking-widest rounded-lg">Live Preview</span>
                                </div>
                            </div>
                            <p id="video_id_display" class="mt-2 text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Video ID: <span class="text-blue-600"></span></p>
                        </div>
                    </div>

                    <!-- Study Material -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Study Material (PDF/DOC)</label>
                        <input type="file" name="study_material" id="topic_study_material"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                        <div id="current_material" class="mt-2 hidden">
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Currently: <span id="material_filename"></span></p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Lesson Content (Optional)</label>
                        <textarea name="content" id="topic_content"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all"></textarea>
                    </div>

                    <!-- Order -->
                    <div class="col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Display Order</label>
                        <input type="number" name="order" id="topic_order" value="0"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <button type="button" onclick="closeTopicModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-xl shadow-blue-200 dark:shadow-none flex items-center justify-center gap-3">
                        <span id="btnText">Save Topic</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    const modal = document.getElementById('topicModal');
    const form = document.getElementById('topicForm');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    $(document).ready(function() {
        $('#topic_content').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });

    function showAlert(type, message) {
        const container = document.getElementById('alertContainer');
        const box = document.getElementById('alertBox');
        const title = document.getElementById('alertTitle');
        const msg = document.getElementById('alertMessage');
        const iconDiv = document.getElementById('alertIcon');
        container.classList.remove('hidden');
        title.innerText = type === 'success' ? 'Success Operation' : 'Action Required';
        msg.innerText = message;
        if (type === 'success') {
            box.className = 'p-5 rounded-[1.5rem] flex items-center justify-between border bg-emerald-50 border-emerald-100 dark:bg-emerald-900/10 dark:border-emerald-800/30 text-emerald-700 dark:text-emerald-400';
            iconDiv.className = 'w-10 h-9 rounded-xl flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/20';
        } else {
            box.className = 'p-5 rounded-[1.5rem] flex items-center justify-between border bg-red-50 border-red-100 dark:bg-red-900/10 dark:border-red-800/30 text-red-700 dark:text-red-400';
            iconDiv.className = 'w-10 h-9 rounded-xl flex items-center justify-center bg-red-100 dark:bg-red-900/20';
        }
        setTimeout(hideAlert, 3000);
    }

    function hideAlert() {
        document.getElementById('alertContainer').classList.add('hidden');
    }

    function extractYouTubeVideoId(url) {
        if (!url) return null;
        let videoId = null;
        try {
            const urlObj = new URL(url);
            if (urlObj.hostname.includes('youtube.com')) {
                videoId = urlObj.searchParams.get('v');
            } else if (urlObj.hostname === 'youtu.be') {
                videoId = urlObj.pathname.slice(1);
            }
        } catch (e) {
            // Fallback for non-URL strings
            const pattern = /(?:v=|\/)([0-9A-Za-z_-]{11}).*/;
            const match = url.match(pattern);
            if (match) videoId = match[1];
        }
        return videoId;
    }

    function updateVideoPreview(url) {
        const videoId = extractYouTubeVideoId(url);
        const container = document.getElementById('video_preview_container');
        const thumb = document.getElementById('video_thumbnail');
        const idSpan = document.querySelector('#video_id_display span');

        if (videoId) {
            thumb.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
            idSpan.innerText = videoId;
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    document.getElementById('topic_video_url').addEventListener('input', function(e) {
        updateVideoPreview(e.target.value);
    });

    function openTopicModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (!isEdit) {
            form.reset();
            document.getElementById('topic_id_pk').value = '';
            $('#topic_content').summernote('code', '');
            document.getElementById('current_material').classList.add('hidden');
            document.getElementById('video_preview_container').classList.add('hidden');
            modalTitle.innerText = 'Add New Topic';
            btnText.innerText = 'Save Topic';
        }
    }

    function closeTopicModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editTopic(id) {
        openTopicModal(true);
        modalTitle.innerText = 'Edit Topic';
        btnText.innerText = 'Update Topic';
        fetch(`/admin/topic/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('topic_id_pk').value = data.id;
                if(document.getElementById('unit_id')) {
                    document.getElementById('unit_id').value = data.unit_id;
                }
                document.getElementById('topic_name').value = data.name;
                
                if (data.video_id) {
                    const fullUrl = `https://www.youtube.com/watch?v=${data.video_id}`;
                    document.getElementById('topic_video_url').value = fullUrl;
                    updateVideoPreview(fullUrl);
                } else {
                    document.getElementById('topic_video_url').value = '';
                    document.getElementById('video_preview_container').classList.add('hidden');
                }
                
                if (data.study_material) {
                    document.getElementById('current_material').classList.remove('hidden');
                    document.getElementById('material_filename').innerText = data.study_material;
                } else {
                    document.getElementById('current_material').classList.add('hidden');
                }

                $('#topic_content').summernote('code', data.content || '');
                document.getElementById('topic_order').value = data.order;
            });
    }

    form.onsubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('topic_id_pk').value;
        const url = id ? `/admin/topic/${id}` : '/admin/topic';
        
        const formData = new FormData(form);
        if(id) {
            formData.append('_method', 'PUT');
        }
        
        submitBtn.disabled = true;
        btnText.innerText = 'Processing...';
        try {
            const response = await fetch(url, {
                method: 'POST', // Use POST with _method spoofing for file uploads
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });
            const result = await response.json();
            if (result.status === 'success') {
                showAlert('success', result.message);
                closeTopicModal();
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('error', result.message || 'Validation failed.');
            }
        } catch (error) {
            showAlert('error', 'Critical operational error.');
        } finally {
            submitBtn.disabled = false;
        }
    };

    function deleteTopic(id) {
        if(confirm('Are you sure you want to delete this topic?')) {
            fetch(`/admin/topic/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showAlert('error', 'Failed to delete topic.');
                }
            });
        }
    }
</script>
@endsection
