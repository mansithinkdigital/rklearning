<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoursePackage;
use App\Models\Course;
use App\Models\Package;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CoursePackageController extends Controller
{
    public function index()
    {
        $coursePackages = CoursePackage::with(['course', 'package'])->latest()->get();
        $courses = Course::where('status', 'Active')->get();
        $packages = Package::all();
        return view('admin.pages.coursepackage.index', compact('coursePackages', 'courses', 'packages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'package_id' => 'required|exists:packages,id',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('admin/uploads/coursepackage/');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            $image->move($path, $imageName);
            $data['image'] = $imageName;
        }

        try {
            CoursePackage::create($data);
            return response()->json(['status' => 'success', 'message' => 'Course Package created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function edit(string $id)
    {
        $coursePackage = CoursePackage::findOrFail($id);
        return response()->json($coursePackage);
    }

    public function update(Request $request, string $id)
    {
        $coursePackage = CoursePackage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'package_id' => 'required|exists:packages,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            $oldImagePath = public_path('admin/uploads/coursepackage/') . $coursePackage->image;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('admin/uploads/coursepackage/');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            $image->move($path, $imageName);
            $data['image'] = $imageName;
        } else {
            unset($data['image']);
        }

        try {
            $coursePackage->update($data);
            return response()->json(['status' => 'success', 'message' => 'Course Package updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $coursePackage = CoursePackage::findOrFail($id);
            
            // Delete image
            $imagePath = public_path('admin/uploads/coursepackage/') . $coursePackage->image;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $coursePackage->delete();
            return response()->json(['status' => 'success', 'message' => 'Course Package deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }
}
