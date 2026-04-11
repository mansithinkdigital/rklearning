<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();
        return view('admin.pages.branch.index', compact('branches'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal' => 'required|string|max:20',
            'contact' => 'required|string|max:20',
            'branch_address' => 'required|string',
            'password' => 'required|string|min:6',
            'branch_id' => 'required|string|unique:branches,branch_id',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['password'] = $request->password;

        try {
            Branch::create($data);
            return response()->json(['status' => 'success', 'message' => 'Branch created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function edit(string $id)
    {
        $branch = Branch::findOrFail($id);
        return response()->json($branch);
    }

    public function update(Request $request, string $id)
    {
        $branch = Branch::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal' => 'required|string|max:20',
            'contact' => 'required|string|max:20',
            'branch_address' => 'required|string',
            'branch_id' => 'required|string|unique:branches,branch_id,' . $id,
            'status' => 'required|string|in:Active,Inactive',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        try {
            $branch->update($data);
            return response()->json(['status' => 'success', 'message' => 'Branch updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();
            return response()->json(['status' => 'success', 'message' => 'Branch deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }
}
