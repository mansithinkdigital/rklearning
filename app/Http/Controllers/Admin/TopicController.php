<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function index($unitId = null)
    {
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
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            Topic::create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Topic added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function edit(string $id)
    {
        $topic = Topic::findOrFail($id);
        return response()->json($topic);
    }

    public function update(Request $request, string $id)
    {
        $topic = Topic::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $topic->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Topic updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
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
}
