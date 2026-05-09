<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Freepdf;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FreePdfController extends Controller
{
    public function index()
    {
        $freePdfs = Freepdf::with(['course', 'unit'])->latest()->get();
        $courses = Course::where('status', 'Active')->get();
        $units = Unit::all();
        $subjects = Subject::all();
        return view('admin.pages.freepdf.index', compact('freePdfs', 'courses', 'units', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'unit_id' => 'required|exists:units,id',
            'pdf_name' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:20480',
        ]);

        $data = $request->only(['course_id', 'unit_id', 'pdf_name']);

        if ($request->hasFile('pdf_file')) {
            try {
                $file = $request->file('pdf_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = public_path('admin/uploads/freepdf/');

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $file->move($path, $fileName);
                $data['pdf_file'] = $fileName;
            } catch (\Exception $e) {
                return back()->with('error', 'File upload failed: ' . $e->getMessage())->withInput();
            }
        }

        try {
            Freepdf::create($data);
            return back()->with('success', 'Free PDF uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Database error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $freePdf = Freepdf::with(['unit'])->findOrFail($id);
        return response()->json($freePdf);
    }

    public function update(Request $request, string $id)
    {
        $freePdf = Freepdf::findOrFail($id);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'unit_id' => 'required|exists:units,id',
            'pdf_name' => 'required|string|max:255',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
        ]);

        $data = $request->only(['course_id', 'unit_id', 'pdf_name']);

        if ($request->hasFile('pdf_file')) {
            try {
                if ($freePdf->pdf_file) {
                    $oldFilePath = public_path('admin/uploads/freepdf/') . $freePdf->pdf_file;
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                $file = $request->file('pdf_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = public_path('admin/uploads/freepdf/');

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $file->move($path, $fileName);
                $data['pdf_file'] = $fileName;
            } catch (\Exception $e) {
                return back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
            }
        }

        try {
            $freePdf->update($data);
            return back()->with('success', 'Free PDF updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Database error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $freePdf = Freepdf::findOrFail($id);

            $filePath = public_path('admin/uploads/freepdf/') . $freePdf->pdf_file;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $freePdf->delete();
            return back()->with('success', 'Free PDF deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong while deleting.');
        }
    }

    public function getUnits($subject_id)
    {
        $units = Unit::where('subject_id', $subject_id)->get();
        return response()->json($units);
    }
}
