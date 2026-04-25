<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function index(Request $request, $unitId = null)
    {
        $unitId = $unitId ?? $request->unit_id;
        
        if ($unitId) {
            $unit = Unit::with('subject.course')->findOrFail($unitId);
            $topics = Topic::where('unit_id', $unitId)->orderBy('order')->get();
            return view('admin.pages.topic.index', compact('topics', 'unit'));
        }
        
        $topics = Topic::with('unit.subject.course')->latest()->get();
        $units = Unit::all();
        return view('admin.pages.topic.index', compact('topics', 'units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'study_material' => 'nullable|file|mimes:pdf,doc,docx,zip',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->except(['study_material', 'video_url']);
            
            if ($request->video_url) {
                $data['video_id'] = $this->extractYouTubeVideoId($request->video_url);
            }

            if ($request->hasFile('study_material')) {
                $file = $request->file('study_material');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('admin/uploads/material/'), $filename);
                $data['study_material'] = $filename;
            }

            Topic::create($data);
            return response()->json(['status' => 'success', 'message' => 'Topic added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit(string $id)
    {
        $topic = Topic::findOrFail($id);
        // Transform video_id back to a full URL for the editor if needed, 
        // or just let the editor handle the ID.
        return response()->json($topic);
    }

    public function update(Request $request, string $id)
    {
        $topic = Topic::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'study_material' => 'nullable|file|mimes:pdf,doc,docx,zip',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->except(['study_material', 'video_url']);

            if ($request->has('video_url')) {
                $data['video_id'] = $this->extractYouTubeVideoId($request->video_url);
            }

            if ($request->hasFile('study_material')) {
                // Delete old file if exists
                if ($topic->study_material && file_exists(public_path('admin/uploads/material/' . $topic->study_material))) {
                    unlink(public_path('admin/uploads/material/' . $topic->study_material));
                }
                
                $file = $request->file('study_material');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('admin/uploads/material/'), $filename);
                $data['study_material'] = $filename;
            }

            $topic->update($data);
            return response()->json(['status' => 'success', 'message' => 'Topic updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $topic = Topic::findOrFail($id);
            $topic->delete();
            return response()->json(['status' => 'success', 'message' => 'Topic deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    private function extractYouTubeVideoId($url)
    {
        if (!$url) return null;
        
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        
        return null;
    }
}
