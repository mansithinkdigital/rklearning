<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.pages.course.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => $request->id ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'description' => 'required|string',
            'long_description' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('admin/uploads/courseimg/');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $image->move($path, $imageName);
            $data['image'] = $imageName;
        }

        try {
            Course::create($data);
            return response()->json(['status' => 'success', 'message' => 'Course created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => $request->id ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'description' => 'required|string',
            'long_description' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            $oldImagePath = public_path('admin/uploads/courseimg/') . $course->image;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('admin/uploads/courseimg/');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $image->move($path, $imageName);
            $data['image'] = $imageName;
        } else {
            unset($data['image']);
        }

        try {
            $course->update($data);
            return response()->json(['status' => 'success', 'message' => 'Course updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $course = Course::findOrFail($id);

            // Delete image
            $imagePath = public_path('admin/uploads/courseimg/') . $course->image;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $course->delete();
            return response()->json(['status' => 'success', 'message' => 'Course deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }
}
