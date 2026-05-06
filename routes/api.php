<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;
use App\Models\Course;
use App\Models\FreeVideo;
use App\Models\Freepdf;
use App\Models\Topic;
use App\Models\CourseSubject;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Media Routes (CORS Fixed)
|--------------------------------------------------------------------------
*/
Route::get('/media/{path}', function ($path) {
    $fullPath = public_path($path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
        'Access-Control-Allow-Headers' => '*',
    ]);
})->where('path', '.*');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/branches', function () {
    return response()->json(Branch::all());
});

Route::get('/courses', function () {
    return response()->json(Course::where('status', 'Active')->latest()->get());
});

Route::get('/courses/{id}', function ($id) {
    $course = Course::with('subjects')->findOrFail($id);
    return response()->json($course);
});

Route::get('/free-videos', function () {
    return response()->json(FreeVideo::latest()->get());
});

Route::get('/free-pdfs', function () {
    return response()->json(Freepdf::with('course')->latest()->get());
});


/*
|--------------------------------------------------------------------------
| Student Authentication
|--------------------------------------------------------------------------
*/
Route::post('/student/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
        'branch_id' => 'required|exists:branches,id',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'mother_name' => $request->mother_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'branch_id' => $request->branch_id,
        'password' => Hash::make($request->password),
        'role' => 'student',
    ]);

    $token = $user->createToken('student-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ], 201);
});

Route::post('/student/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password) || $user->role !== 'student') {
        return response()->json(['message' => 'Invalid student credentials.'], 401);
    }

    $token = $user->createToken('student-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});


/*
|--------------------------------------------------------------------------
| Protected Student Routes (Requires Sanctum Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('student')->group(function () {

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    });

    Route::get('/profile', function (Request $request) {
        return response()->json($request->user()->load('branch'));
    });

    Route::post('/profile', function (Request $request) {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);
        
        $user->update($request->only('name', 'phone', 'address'));
        return response()->json($user);
    });

    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();
        $enrolledCourses = $user->courses()->wherePivot('status', 'approved')->get();
        $pendingRequests = $user->courses()->wherePivot('status', 'pending')->get();
        
        return response()->json([
            'user' => $user,
            'enrolled_courses' => $enrolledCourses,
            'pending_requests' => $pendingRequests,
        ]);
    });

    Route::get('/my-courses', function (Request $request) {
        return response()->json($request->user()->courses()->wherePivot('status', 'approved')->get());
    });

    Route::get('/my-courses/{course_id}', function (Request $request, $course_id) {
        $user = $request->user();
        $course = Course::with([
            'subjects.units.topics',
            'subjects.units.paidVideos',
            'subjects.units.freePdfs'
        ])->findOrFail($course_id);

        $enrollment = $user->courses()->where('course_id', $course_id)->first();
        if (!$enrollment || $enrollment->pivot->status !== 'approved') {
            return response()->json(['message' => 'Unauthorized or expired course access.'], 403);
        }

        return response()->json($course);
    });

    Route::get('/study-material', function (Request $request) {
        $user = $request->user();
        $enrolledCourseIds = $user->courses()
            ->wherePivot('status', 'approved')
            ->pluck('courses.id');

        $studyMaterials = Topic::whereHas('unit.subject', function($q) use ($enrolledCourseIds) {
                $q->whereIn('course_id', $enrolledCourseIds);
            })
            ->whereNotNull('study_material')
            ->with(['unit.subject.course'])
            ->latest()
            ->get();

        return response()->json($studyMaterials);
    });

    Route::get('/exams', function (Request $request) {
        $user = $request->user();
        $enrolledCourseIds = $user->courses()->wherePivot('status', 'approved')->pluck('courses.id');
        
        $courseSubjects = CourseSubject::whereIn('course_id', $enrolledCourseIds)
            ->with(['subject', 'course', 'mcqs'])
            ->get();

        foreach($courseSubjects as $cs) {
            $cs->result = ExamResult::where('user_id', $user->id)
                ->where('course_subject_id', $cs->id)
                ->first();
        }

        return response()->json($courseSubjects);
    });

    Route::get('/exams/{course_subject_id}/start', function (Request $request, $course_subject_id) {
        $user = $request->user();
        $courseSubject = CourseSubject::with(['course', 'subject', 'mcqs'])->findOrFail($course_subject_id);

        $isEnrolled = $user->courses()->where('courses.id', $courseSubject->course_id)->exists();
        if (!$isEnrolled) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        $previousResult = ExamResult::where('user_id', $user->id)
            ->where('course_subject_id', $course_subject_id)
            ->first();
        
        if ($previousResult) {
            return response()->json(['message' => 'Exam already completed.'], 400);
        }

        return response()->json([
            'course_subject' => $courseSubject->makeHidden('mcqs'),
            'questions' => $courseSubject->mcqs->makeHidden('answer')
        ]);
    });

    Route::post('/exams/{course_subject_id}/submit', function (Request $request, $course_subject_id) {
        $user = $request->user();
        $courseSubject = CourseSubject::with('mcqs')->findOrFail($course_subject_id);
        
        $isEnrolled = $user->courses()->where('courses.id', $courseSubject->course_id)->exists();
        if (!$isEnrolled) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        $answers = $request->input('answers', []);
        $correctCount = 0;
        $totalQuestions = $courseSubject->mcqs->count();

        foreach ($courseSubject->mcqs as $mcq) {
            $studentAnswer = $answers[$mcq->id] ?? null;
            if ($studentAnswer == $mcq->answer) {
                $correctCount++;
            }
        }

        $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;
        $status = ($score >= ($courseSubject->pass_marks / ($courseSubject->total_marks ?: 1) * 100)) ? 'pass' : 'fail';

        $result = ExamResult::create([
            'user_id'           => $user->id,
            'course_subject_id' => $course_subject_id,
            'total_questions'   => $totalQuestions,
            'correct_answers'   => $correctCount,
            'score'             => $score,
            'status'            => $status,
            'student_answers'   => $answers,
        ]);

        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    });
});
