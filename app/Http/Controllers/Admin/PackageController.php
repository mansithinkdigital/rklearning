<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.pages.package.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'package_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            Package::create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Package added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function edit(string $id)
    {
        $package = Package::findOrFail($id);
        return response()->json($package);
    }

    public function update(Request $request, string $id)
    {
        $package = Package::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'package_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $package->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Package updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $package = Package::findOrFail($id);
            $package->delete();
            return response()->json(['status' => 'success', 'message' => 'Package deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }
}
