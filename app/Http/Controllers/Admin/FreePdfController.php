<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Freepdf;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class FreePdfController extends Controller
{
    public function index()
    {
<<<<<<< Updated upstream
        $freePdfs = Freepdf::with(['course'])->latest()->get();
        $courses = Course::where('status', 'Active')->get();
        return view('admin.pages.freepdf.index', compact('freePdfs', 'courses'));
=======
        $freePdfs = Freepdf::with(['course', 'package', 'unit'])->latest()->get();
        $courses = Course::where('status', 'Active')->get();
        $packages = Package::all();
        $units = \App\Models\Unit::all();
        $subjects = \App\Models\Subject::all();
        return view('admin.pages.freepdf.index', compact('freePdfs', 'courses', 'packages', 'units', 'subjects'));
>>>>>>> Stashed changes
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
<<<<<<< Updated upstream
=======
            'unit_id' => 'required|exists:units,id',
            'package_id' => 'required|exists:packages,id',
>>>>>>> Stashed changes
            'pdf_name' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = public_path('admin/uploads/freepdf/');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            $file->move($path, $fileName);
            $data['pdf_file'] = $fileName;
        }

        try {
            Freepdf::create($data);
            return response()->json(['status' => 'success', 'message' => 'Free PDF uploaded successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function edit(string $id)
    {
        $freePdf = Freepdf::findOrFail($id);
        return response()->json($freePdf);
    }

    public function update(Request $request, string $id)
    {
        $freePdf = Freepdf::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
<<<<<<< Updated upstream
=======
            'unit_id' => 'required|exists:units,id',
            'package_id' => 'required|exists:packages,id',
>>>>>>> Stashed changes
            'pdf_name' => 'required|string|max:255',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('pdf_file')) {
            // Delete old file
            $oldFilePath = public_path('admin/uploads/freepdf/') . $freePdf->pdf_file;
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            $file = $request->file('pdf_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = public_path('admin/uploads/freepdf/');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            $file->move($path, $fileName);
            $data['pdf_file'] = $fileName;
        } else {
            unset($data['pdf_file']);
        }

        try {
            $freePdf->update($data);
            return response()->json(['status' => 'success', 'message' => 'Free PDF updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $freePdf = Freepdf::findOrFail($id);
            
            // Delete file
            $filePath = public_path('admin/uploads/freepdf/') . $freePdf->pdf_file;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $freePdf->delete();
            return response()->json(['status' => 'success', 'message' => 'Free PDF deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }
}
