@extends('admin.layouts.main')

@section('title', 'Curriculum Architect - ' . $course->name)

@section('content')
<!-- Header Section -->
<div class="mb-10">
    <div class="flex items-center gap-2 mb-3">
        <a href="{{ route('admin.course.index') }}" class="group flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform"></i>
            Inventory
        </a>
        <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>
        <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-lg">Course Active</span>
    </div>
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-xl shadow-blue-500/20">
                <i data-lucide="layout-template" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter leading-none mb-2 uppercase">{{ $course->name }}</h1>
                <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Architecting {{ $course->subjects->count() }} Subjects and Modules
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="addSubject()" class="group bg-slate-900 dark:bg-white dark:text-slate-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-2xl flex items-center gap-3">
                <i data-lucide="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
                New Subject
            </button>
        </div>
    </div>
</div>

<!-- Main Workspace -->
<div class="grid grid-cols-12 gap-8 min-h-[750px] items-stretch">
    <!-- Left: Structure Tree (4 columns) -->
    <div class="col-span-12 lg:col-span-4 h-full">
        <div class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden flex flex-col h-full ring-4 ring-slate-50 dark:ring-slate-900/50">
            <div class="p-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                <div class="flex items-center justify-between">
                    <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="git-branch" class="w-4 h-4 text-blue-500"></i>
                        Tree Navigator
                    </h2>
                    <span class="text-[9px] font-black bg-blue-600 text-white px-2 py-1 rounded-md uppercase tracking-tighter">Root</span>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[650px] custom-scrollbar space-y-4">
                @forelse($course->subjects as $subject)
                    <div class="subject-node" id="node-subject-{{ $subject->id }}">
                        <!-- Subject Row -->
                        <div class="group/subject flex items-center gap-2">
                            <button onclick="toggleNode('children-subject-{{ $subject->id }}', this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-400">
                                <i data-lucide="chevron-right" class="w-4 h-4 transition-transform duration-300"></i>
                            </button>
                            <div class="flex-1 flex items-center justify-between p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 hover:border-blue-500 transition-all cursor-pointer select-none role-item" onclick="selectSubject({{ $subject->id }}, '{{ addslashes($subject->name) }}')">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-black text-slate-800 dark:text-slate-100 tracking-tight">{{ $subject->name }}</span>
                                </div>
                                <div class="flex items-center gap-1 opacity-0 group-hover/subject:opacity-100 transition-opacity">
                                    <button onclick="addUnit({{ $subject->id }}, event)" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white dark:bg-slate-800 text-emerald-500 shadow-sm border border-slate-100 dark:border-slate-700 hover:scale-110 transition-all">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Units (Children) -->
                        <div id="children-subject-{{ $subject->id }}" class="hidden ml-12 mt-3 space-y-3 border-l-2 border-slate-100 dark:border-slate-800/50 pl-6">
                            @forelse($subject->units as $unit)
                                <div class="unit-node" id="node-unit-{{ $unit->id }}">
                                    <div class="group/unit flex items-center gap-2">
                                        <button onclick="toggleNode('children-unit-{{ $unit->id }}', this)" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-slate-400 focus:outline-none">
                                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 transition-transform duration-300"></i>
                                        </button>
                                        <div class="flex-1 flex items-center justify-between p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 hover:border-emerald-500 transition-all cursor-pointer select-none role-item" onclick="selectUnit({{ $unit->id }}, '{{ addslashes($unit->name) }}', {{ $unit->order }}, {{ $subject->id }})">
                                            <div class="flex items-center gap-3">
                                                <div class="w-1.5 h-4 bg-emerald-500/20 dark:bg-emerald-900/30 rounded-full border border-emerald-500/50"></div>
                                                <span class="text-[13px] font-bold text-slate-600 dark:text-slate-300">{{ $unit->name }}</span>
                                            </div>
                                            <button onclick="addTopic({{ $unit->id }}, event)" class="opacity-0 group-hover/unit:opacity-100 w-7 h-7 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:scale-110 transition-all">
                                                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modules & Resources -->
                                    <div id="children-unit-{{ $unit->id }}" class="hidden mt-2 space-y-1.5">
                                        <!-- Topics/Lessons -->
                                        @foreach($unit->topics as $topic)
                                            <div class="flex items-center justify-between p-3 pl-5 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/10 group/topic cursor-pointer border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900/30 role-item" onclick="selectTopic({{ $topic->id }})">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="{{ $topic->video_id ? 'play-circle' : 'file-text' }}" class="w-4 h-4 {{ $topic->video_id ? 'text-blue-500' : 'text-indigo-400' }}"></i>
                                                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 group-hover/topic:text-indigo-600 transition-colors">{{ $topic->name }}</span>
                                                </div>
                                                <i data-lucide="chevron-right" class="w-3 h-3 opacity-0 group-hover/topic:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></i>
                                            </div>
                                        @endforeach
                                        
                                        <!-- Legacy Paid Videos -->
                                        @foreach($unit->paidVideos as $pvideo)
                                            <div class="flex items-center justify-between p-3 pl-5 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/10 group/pvideo cursor-pointer border border-transparent hover:border-red-100 dark:hover:border-red-900/30 role-item">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="youtube" class="w-4 h-4 text-red-500"></i>
                                                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 group-hover/pvideo:text-red-600 transition-colors">{{ $pvideo->title }}</span>
                                                </div>
                                                <span class="text-[8px] font-black uppercase text-red-400 bg-red-50 px-1.5 py-0.5 rounded">Legacy</span>
                                            </div>
                                        @endforeach

                                        @if($unit->topics->isEmpty() && $unit->paidVideos->isEmpty())
                                            <div class="py-2 pl-4 text-[9px] font-black text-slate-300 dark:text-slate-700 uppercase tracking-widest italic">Empty Module</div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-4 text-[9px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest text-center border-2 border-dashed border-slate-50 dark:border-slate-800 rounded-2xl">No Units</div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/40 rounded-[2rem] flex items-center justify-center mx-auto mb-6 scale-90 group-hover:scale-100 transition-transform">
                            <i data-lucide="layers-3" class="w-10 h-10 text-slate-300"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-4 text-center">Empty Catalog</h4>
                        <button onclick="addSubject()" class="px-6 py-3 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-500/20">New Subject</button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right: Smart Editor (8 columns) -->
    <div class="col-span-12 lg:col-span-8 flex flex-col items-stretch h-full">
        <!-- Editor Viewport -->
        <div id="editor-canvas" class="bg-white dark:bg-[#0b1120] rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl h-full flex flex-col overflow-hidden relative transition-all duration-500">
            <!-- Loading Overlay -->
            <div id="loader-overlay" class="hidden absolute inset-0 z-50 bg-white/80 dark:bg-[#0b1120]/80 backdrop-blur-sm flex items-center justify-center">
                <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            </div>

            <!-- Empty Selection Panel -->
            <div id="empty-selection" class="flex-1 flex flex-col items-center justify-center p-20 text-center select-none">
                <div class="relative mb-12">
                    <div class="absolute inset-0 bg-blue-500 rounded-full blur-[60px] opacity-10 animate-pulse"></div>
                    <div class="relative w-32 h-32 bg-slate-50 dark:bg-slate-800/50 rounded-[3rem] flex items-center justify-center border border-slate-100 dark:border-slate-700 shadow-inner">
                        <i data-lucide="mouse-pointer-2" class="w-12 h-12 text-slate-300 animate-bounce duration-[2000ms]"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter mb-4">Structure Viewport</h3>
                <p class="max-w-sm text-sm font-bold text-slate-400 leading-relaxed uppercase tracking-[0.2em] text-[10px] opacity-70">
                    Your workspace is ready. Pick an entity from the Navigator to begin detailing your course curriculum.
                </p>
            </div>

            <!-- Unified Form Template -->
            <div id="active-editor" class="hidden flex-1 flex flex-col h-full animate-in zoom-in-95 duration-300 overflow-y-auto custom-scrollbar">
                <!-- Editor Header -->
                <div class="p-8 lg:p-10 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/10">
                    <div class="flex items-center gap-6">
                        <div id="type-badge" class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg">
                            <i id="type-icon" data-lucide="box" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                            <span id="type-label" class="text-[10px] font-black uppercase tracking-[0.2em] mb-1.5 block">Entity Type</span>
                            <h3 id="entity-title" class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">Untitled Element</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" id="delete-btn" class="w-12 h-12 flex items-center justify-center bg-red-50 dark:bg-red-900/10 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                        <button onclick="closeEditor()" class="w-12 h-12 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-2xl transition-all">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Area -->
                <div class="p-10 lg:p-14">
                    <form id="unified-form" class="space-y-10">
                        @csrf
                        <input type="hidden" name="id" id="form-id">
                        <input type="hidden" name="parent_id" id="form-parent-id">
                        <input type="hidden" name="type" id="form-type">

                        <div id="standard-fields" class="grid grid-cols-12 gap-8">
                            <!-- Name Field -->
                            <div class="col-span-12 md:col-span-9 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Display Title <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="name" id="field-name" required class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-50 dark:border-slate-800 rounded-3xl px-8 py-5 text-base font-black text-slate-900 dark:text-white focus:border-blue-500 focus:ring-0 transition-all placeholder:text-slate-300" placeholder="Enter title name...">
                                </div>
                            </div>
                            <!-- Order Field -->
                            <div id="order-group" class="col-span-12 md:col-span-3 space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Listing Order</label>
                                <input type="number" name="order" id="field-order" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-50 dark:border-slate-800 rounded-3xl px-8 py-5 text-base font-black text-slate-900 dark:text-white focus:border-blue-500 focus:ring-0 transition-all">
                            </div>

                            <!-- Topic Content (Summernote) -->
                            <div id="content-group" class="col-span-12 space-y-3 hidden">
                                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Lesson Curriculum & Material</label>
                                <div class="rounded-3xl overflow-hidden border-2 border-slate-50 dark:border-slate-800">
                                    <textarea name="content" id="field-content"></textarea>
                                </div>
                            </div>

                            <!-- Topic Extra Fields (Video & File) -->
                            <div id="topic-extras" class="col-span-12 grid grid-cols-12 gap-8 hidden">
                                <div class="col-span-12 md:col-span-6 space-y-3">
                                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">YouTube Video URL</label>
                                    <input type="url" name="video_url" id="field-video-url" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-50 dark:border-slate-800 rounded-3xl px-8 py-5 text-sm font-bold text-slate-900 dark:text-white focus:border-blue-500 transition-all" placeholder="https://youtube.com/watch?v=...">
                                </div>
                                <div class="col-span-12 md:col-span-6 space-y-3">
                                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Study Material (PDF)</label>
                                    <div class="relative">
                                        <input type="file" name="study_material" id="field-material" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-slate-50 dark:border-slate-800 rounded-3xl px-8 py-4 text-sm font-bold text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                        <p id="current-material" class="mt-2 text-[9px] font-bold text-emerald-500 px-4 hidden">Existing file: <span id="material-filename"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="pt-10 flex flex-col md:flex-row gap-4">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 dark:from-white dark:to-slate-100 text-white dark:text-slate-900 px-10 py-6 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-2xl hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-4">
                                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                Save Entity Changes
                            </button>
                            <button type="button" onclick="closeEditor()" class="px-10 py-6 rounded-[2rem] bg-slate-100 dark:bg-slate-800 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Discard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action System -->
<div id="global-toast" class="fixed bottom-12 right-12 z-[200] transform translate-y-20 opacity-0 transition-all duration-500">
    <div class="px-8 py-5 rounded-[2rem] bg-slate-900 dark:bg-white dark:text-slate-900 text-white shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center gap-5">
        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
            <i data-lucide="badge-check" class="w-4 h-4 text-white"></i>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest opacity-50 mb-0.5">Notification</p>
            <p id="toast-text" class="text-sm font-black tracking-tight">Changes Persisted Successfully</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // --- State Management ---
    let currentType = null;
    let currentId = null;

    // --- UI Logic ---
    function toggleNode(id, btn) {
        const el = document.getElementById(id);
        const icon = btn.querySelector('i');
        el.classList.toggle('hidden');
        if (el.classList.contains('hidden')) {
            icon.classList.remove('rotate-90');
        } else {
            icon.classList.add('rotate-90');
        }
    }

    function closeEditor() {
        document.getElementById('empty-selection').classList.remove('hidden');
        document.getElementById('active-editor').classList.add('hidden');
        document.querySelectorAll('.role-item').forEach(x => x.classList.remove('ring-4', 'ring-blue-500/20', 'border-blue-500'));
    }

    function highlightNode(type, id) {
        document.querySelectorAll('.role-item').forEach(x => x.classList.remove('ring-4', 'ring-blue-500/20', 'border-blue-500'));
        // Find row inside node
        const node = document.querySelector(`#node-${type}-${id} .role-item`);
        if(node) {
            node.classList.add('ring-4', 'ring-blue-500/20', 'border-blue-500');
        }
    }

    function setupEditor(type, title, config) {
        currentType = type;
        document.getElementById('empty-selection').classList.add('hidden');
        document.getElementById('active-editor').classList.remove('hidden');
        
        document.getElementById('form-type').value = type;
        document.getElementById('entity-title').innerText = title;
        document.getElementById('type-label').innerText = type + ' Settings';
        
        // Style by type
        const badge = document.getElementById('type-badge');
        const icon = document.getElementById('type-icon');
        const orderGroup = document.getElementById('order-group');
        const contentGroup = document.getElementById('content-group');
        const topicExtras = document.getElementById('topic-extras');

        const themes = {
            subject: { color: 'bg-blue-600', shadow: 'shadow-blue-500/30', icon: 'layers' },
            unit: { color: 'bg-emerald-600', shadow: 'shadow-emerald-500/30', icon: 'git-branch' },
            topic: { color: 'bg-indigo-600', shadow: 'shadow-indigo-500/30', icon: 'book-open-check' }
        };

        const theme = themes[type];
        badge.className = `w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg ${theme.color} ${theme.shadow}`;
        icon.setAttribute('data-lucide', theme.icon);
        lucide.createIcons();

        // Specific fields
        orderGroup.classList.toggle('hidden', type === 'subject');
        contentGroup.classList.toggle('hidden', type !== 'topic');
        topicExtras.classList.toggle('hidden', type !== 'topic');

        // Delete button
        const delBtn = document.getElementById('delete-btn');
        if (currentId) {
            delBtn.classList.remove('hidden');
            delBtn.onclick = () => deleteEntity(type, currentId);
        } else {
            delBtn.classList.add('hidden');
        }
    }

    // --- Entity Actions ---
    function addSubject() {
        currentId = null;
        setupEditor('subject', 'Create New Subject');
        document.getElementById('form-id').value = '';
        document.getElementById('field-name').value = '';
        document.getElementById('field-name').focus();
    }

    function selectSubject(id, name) {
        currentId = id;
        setupEditor('subject', 'Modify Subject');
        document.getElementById('form-id').value = id;
        document.getElementById('field-name').value = name;
        highlightNode('subject', id);
    }

    function addUnit(subjectId, e) {
        if(e) e.stopPropagation();
        currentId = null;
        setupEditor('unit', 'New Academic Unit');
        document.getElementById('form-id').value = '';
        document.getElementById('form-parent-id').value = subjectId;
        document.getElementById('field-name').value = '';
        document.getElementById('field-order').value = 0;
        document.getElementById('field-name').focus();
    }

    async function selectUnit(id, name, order, subjectId) {
        currentId = id;
        setupEditor('unit', 'Update Unit');
        document.getElementById('form-id').value = id;
        document.getElementById('form-parent-id').value = subjectId;
        document.getElementById('field-name').value = name;
        document.getElementById('field-order').value = order;
        highlightNode('unit', id);
    }

    function addTopic(unitId, e) {
        if(e) e.stopPropagation();
        currentId = null;
        setupEditor('topic', 'Assemble New Topic');
        document.getElementById('form-id').value = '';
        document.getElementById('form-parent-id').value = unitId;
        document.getElementById('field-name').value = '';
        document.getElementById('field-order').value = 0;
        document.getElementById('field-video-url').value = '';
        document.getElementById('field-material').value = '';
        document.getElementById('current-material').classList.add('hidden');
        $('#field-content').summernote('code', '');
        document.getElementById('field-name').focus();
    }

    async function selectTopic(id) {
        currentId = id;
        document.getElementById('loader-overlay').classList.remove('hidden');
        try {
            const res = await fetch(`/admin/topic/${id}/edit`);
            const data = await res.json();
            setupEditor('topic', 'Resource Management');
            document.getElementById('form-id').value = data.id;
            document.getElementById('form-parent-id').value = data.unit_id;
            document.getElementById('field-name').value = data.name;
            document.getElementById('field-order').value = data.order;
            document.getElementById('field-video-url').value = data.video_id ? `https://www.youtube.com/watch?v=${data.video_id}` : '';
            
            const materialIndicator = document.getElementById('current-material');
            if(data.study_material) {
                materialIndicator.classList.remove('hidden');
                document.getElementById('material-filename').innerText = data.study_material;
            } else {
                materialIndicator.classList.add('hidden');
            }

            $('#field-content').summernote('code', data.content || '');
            highlightNode('topic', id);
        } finally {
            document.getElementById('loader-overlay').classList.add('hidden');
        }
    }

    // --- Form Submission ---
    document.getElementById('unified-form').onsubmit = async (e) => {
        e.preventDefault();
        const type = document.getElementById('form-type').value;
        const id = document.getElementById('form-id').value;
        const parentId = document.getElementById('form-parent-id').value;
        
        const formData = new FormData();
        formData.append('id', id);
        formData.append('type', type);
        formData.append('name', document.getElementById('field-name').value);
        formData.append('order', document.getElementById('field-order').value || 0);
        
        if(id) formData.append('_method', 'PUT');

        let url;
        if(type === 'subject') {
            url = id ? `/admin/subject/${id}` : '/admin/subject';
            formData.append('course_id', {{ $course->id }});
        } else if(type === 'unit') {
            url = id ? `/admin/unit/${id}` : '/admin/unit';
            formData.append('subject_id', parentId);
        } else if(type === 'topic') {
            url = id ? `/admin/topic/${id}` : '/admin/topic';
            formData.append('unit_id', parentId);
            formData.append('content', $('#field-content').summernote('code'));
            formData.append('video_url', document.getElementById('field-video-url').value);
            const materialFile = document.getElementById('field-material').files[0];
            if(materialFile) formData.append('study_material', materialFile);
        }

        document.getElementById('loader-overlay').classList.remove('hidden');

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            const result = await res.json();
            if(result.status === 'success') {
                showToast(result.message);
                setTimeout(() => window.location.reload(), 1200);
            } else if(result.errors) {
                const firstError = Object.values(result.errors)[0][0];
                alert(firstError);
            }
        } catch (err) {
            console.error(err);
            alert('Operation failed. Check logs.');
        } finally {
            document.getElementById('loader-overlay').classList.add('hidden');
        }
    };

    async function deleteEntity(type, id) {
        if(!confirm(`Confirm deletion of this ${type}? This will remove all child elements as well.`)) return;
        
        document.getElementById('loader-overlay').classList.remove('hidden');
        try {
            const res = await fetch(`/admin/${type}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const result = await res.json();
            if(result.status === 'success') {
                showToast(result.message);
                setTimeout(() => window.location.reload(), 1000);
            }
        } finally {
            document.getElementById('loader-overlay').classList.add('hidden');
        }
    }

    function showToast(msg) {
        const toast = document.getElementById('global-toast');
        document.getElementById('toast-text').innerText = msg;
        toast.classList.remove('opacity-0', 'translate-y-20');
        setTimeout(() => toast.classList.add('opacity-0', 'translate-y-20'), 3000);
    }

    // --- Init ---
    $(document).ready(function() {
        $('#field-content').summernote({
            height: 350,
            placeholder: 'Compose lesson architecture...',
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video', 'table']],
                ['view', ['fullscreen', 'codeview']]
            ],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'pre']
        });
        lucide.createIcons();
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; }
    
    .role-item { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .role-item:hover { transform: translateX(4px); }
</style>
@endsection
