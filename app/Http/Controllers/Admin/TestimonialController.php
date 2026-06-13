<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = \App\Models\Testimonial::latest()->get();
        return view('admin.pages.testimonial.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('admin/uploads/testimonialimg'), $imageName);
            $data['image'] = 'admin/uploads/testimonialimg/' . $imageName;
        }

        \App\Models\Testimonial::create($data);

        return redirect()->back()->with('success', 'Testimonial created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $testimonial = \App\Models\Testimonial::findOrFail($id);
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('admin/uploads/testimonialimg'), $imageName);
            $data['image'] = 'admin/uploads/testimonialimg/' . $imageName;
        }

        $testimonial->update($data);

        return redirect()->back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(string $id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);
        
        if ($testimonial->image && file_exists(public_path($testimonial->image))) {
            unlink(public_path($testimonial->image));
        }

        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
}
