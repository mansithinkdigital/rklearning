<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::latest()->get();
        return view('admin.pages.vacancy.index', compact('vacancies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'experience'  => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Vacancy::create($request->only('title', 'experience', 'description'));

        return redirect()->back()->with('success', 'Vacancy created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'experience'  => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update($request->only('title', 'experience', 'description'));

        return redirect()->back()->with('success', 'Vacancy updated successfully.');
    }

    public function destroy(string $id)
    {
        Vacancy::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Vacancy deleted successfully.');
    }
}
