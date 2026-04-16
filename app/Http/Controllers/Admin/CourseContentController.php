<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\Topic;

class CourseContentController extends Controller
{
    public function manage(Course $course)
    {
        $course->load(['subjects' => function($q) {
            $q->orderBy('id', 'asc'); // or use an order column if exists
        }, 'subjects.units' => function($q) {
            $q->orderBy('order', 'asc');
        }, 'subjects.units.topics' => function($q) {
            $q->orderBy('order', 'asc');
        }]);
        
        return view('admin.pages.course.manage', compact('course'));
    }
}
