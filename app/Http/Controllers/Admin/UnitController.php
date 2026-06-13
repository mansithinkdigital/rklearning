<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index(Request $request, $subjectId = null)
    {
        $subjectId = $subjectId ?? $request->subject_id;
        if ($subjectId) {
            $subject = Subject::with('course')->findOrFail($subjectId);
            $units = Unit::withCount('topics')->where('subject_id', $subjectId)->orderBy('order')->get();
            return view('admin.pages.unit.index', compact('units', 'subject'));
        }
        $units = Unit::withCount('topics')->with('subject.course')->latest()->get();
        $subjects = Subject::all();
        return view('admin.pages.unit.index', compact('units', 'subjects'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        try {
            Unit::create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Unit added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        try {
            $unit->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Unit updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $unit = Unit::findOrFail($id);
            $unit->delete();
            return response()->json(['status' => 'success', 'message' => 'Unit deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }
}
