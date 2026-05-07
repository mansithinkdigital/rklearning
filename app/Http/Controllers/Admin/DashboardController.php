<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $departmentsCount = Branch::count();
        $facultyCount = User::where('role', 'admin')->count();
        $activeCoursesCount = Course::where('status', 'Active')->count();
        $studentsCount = User::where('role', 'student')->count();
        $vacanciesCount = Vacancy::count();
        return view('admin.pages.dashboard', compact(
            'departmentsCount',
            'facultyCount',
            'activeCoursesCount',
            'studentsCount',
            'vacanciesCount'
        ));
    }
}
