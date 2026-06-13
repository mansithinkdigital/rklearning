<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.pages.gallery.index', compact('galleries'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:9999',
        ]);
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('admin/uploads/galleryimg/'), $imageName);
        Gallery::create([
            'image' => $imageName,
        ]);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery created successfully');
    }

    public function edit(string $id)
    {
        $gallery = Gallery::find($id);
        return view('admin.pages.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:9999',
        ]);

        $gallery = Gallery::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete the old image from public folder
            $oldPath = public_path('admin/uploads/galleryimg/' . $gallery->image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin/uploads/galleryimg/'), $imageName);
            $gallery->image = $imageName;
        }

        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(string $id)
    {
        $gallery = Gallery::find($id);

        // Delete physical image file
        if ($gallery && $gallery->image) {
            $filePath = public_path('admin/uploads/galleryimg/' . $gallery->image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image deleted successfully.');
    }
}
