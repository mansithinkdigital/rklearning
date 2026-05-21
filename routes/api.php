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

    Route::post('/enroll', function (Request $request) {
        $user = $request->user();
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_method' => 'string|in:online,offline',
            'razorpay_payment_id' => 'required_if:payment_method,online|string|nullable',
            'razorpay_order_id' => 'required_if:payment_method,online|string|nullable',
        ]);

        $courseId = $request->input('course_id');
        $paymentMethod = $request->input('payment_method', 'offline');
        
        // Check if already enrolled or requested
        $existingEnrollment = $user->courses()->where('course_id', $courseId)->first();
        if ($existingEnrollment) {
            return response()->json([
                'message' => 'You have already requested enrollment or are already enrolled in this course.',
                'status' => $existingEnrollment->pivot->status
            ], 400);
        }

        $user->courses()->attach($courseId, [
            'status' => $paymentMethod == 'online' ? 'approved' : 'pending',
            'payment_method' => $paymentMethod,
            'amount' => \App\Models\Course::find($courseId)->price ?? 0,
            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
            'razorpay_order_id' => $request->input('razorpay_order_id'),
        ]);

        return response()->json([
            'message' => 'Enrollment request submitted successfully.',
            'success' => true
        ]);
    });

    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();
        
        // Basic enrollments
        $enrolledCourses = $user->courses()->wherePivot('status', 'approved')->get();
        $pendingRequests = $user->courses()->wherePivot('status', 'pending')->get();
        
        // Auto-assign certificates for completed students who don't have one yet
        foreach ($enrolledCourses as $course) {
            if (!$course->pivot->certificate_no) {
                if ($user->checkCourseCompletion($course)) {
                    $certNo = 'RK-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) . '-' . str_pad($course->id, 3, '0', STR_PAD_LEFT);
                    $user->courses()->updateExistingPivot($course->id, ['certificate_no' => $certNo]);
                    // Refresh the course object to include the new pivot data
                    $course->pivot->certificate_no = $certNo;
                }
            }
        }

        // Identify courses with certificates
        $certificates = $user->courses()
            ->wherePivot('status', 'approved')
            ->wherePivotNotNull('certificate_no')
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'certificate_no' => $course->pivot->certificate_no,
                    'download_url' => url("/api/student/certificate/{$course->id}/download"),
                    'marksheet_download_url' => url("/api/student/marksheet/{$course->id}/download"),
                ];
            });

        // Calculate pending fees
        $pendingFees = $user->courses()
            ->wherePivot('status', 'approved')
            ->sum('course_user.amount');

        return response()->json([
            'user' => $user,
            'enrolled_courses' => $enrolledCourses,
            'pending_requests' => $pendingRequests,
            'certificates' => $certificates,
            'stats' => [
                'active_courses' => $enrolledCourses->count(),
                'certificates_count' => $certificates->count(),
                'pending_fees' => $pendingFees,
                'attendance' => '100%',
            ]
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

        $paidVideoIds = \App\Models\PaidVideo::where('course_id', $course_id)
            ->whereNotNull('video_id')
            ->where('video_id', '!=', '')
            ->pluck('video_id')
            ->toArray();
            
        $topicVideoIds = \App\Models\Topic::whereHas('unit.subject', function ($q) use ($course_id) {
            $q->where('course_id', $course_id);
        })
            ->whereNotNull('video_id')
            ->where('video_id', '!=', '')
            ->pluck('video_id')
            ->toArray();

        $allRequiredVideoIds = array_values(array_unique(array_merge($paidVideoIds, $topicVideoIds)));
        $totalVideos = count($allRequiredVideoIds);

        $completedCount = 0;
        if ($totalVideos > 0) {
            $completedCount = \App\Models\VideoCompletion::where('user_id', $user->id)
                ->whereIn('video_id', $allRequiredVideoIds)
                ->where('is_completed', true)
                ->count();
        }

        $completedVideos = \App\Models\VideoCompletion::where('user_id', $user->id)
            ->where('course_id', $course_id)
            ->where('is_completed', true)
            ->pluck('video_id')
            ->toArray();

        $progress = ($totalVideos > 0) ? ($completedCount / $totalVideos) * 100 : 100;

        return response()->json([
            'course' => $course,
            'completed_videos' => $completedVideos,
            'progress' => $progress
        ]);
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

            $paidVideoIds = \App\Models\PaidVideo::where('course_id', $cs->course_id)
                ->whereNotNull('video_id')
                ->where('video_id', '!=', '')
                ->pluck('video_id')
                ->toArray();
                
            $topicVideoIds = \App\Models\Topic::whereHas('unit.subject', function ($q) use ($cs) {
                $q->where('course_id', $cs->course_id);
            })
                ->whereNotNull('video_id')
                ->where('video_id', '!=', '')
                ->pluck('video_id')
                ->toArray();

            $allRequiredVideoIds = array_values(array_unique(array_merge($paidVideoIds, $topicVideoIds)));
            $totalVideos = count($allRequiredVideoIds);

            if ($totalVideos === 0) {
                $cs->setAttribute('is_unlocked', true);
            } else {
                $completedCount = \App\Models\VideoCompletion::where('user_id', $user->id)
                    ->whereIn('video_id', $allRequiredVideoIds)
                    ->where('is_completed', true)
                    ->count();

                $cs->setAttribute('is_unlocked', ($completedCount >= $totalVideos));
            }
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
        
        if ($previousResult && $previousResult->reattempt_status !== 'allowed') {
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
            // Robust key matching: handle both int and string keys from Flutter
            $studentAnswer = $answers[$mcq->id] ?? ($answers[(string)$mcq->id] ?? null);
            
            if ($studentAnswer !== null) {
                $studentAnswerStr = strtoupper(trim((string)$studentAnswer));
                $dbAnswerStr = trim((string)$mcq->answer);

                $correctLetter = null;
                
                // If the DB stored the letter (A, B, C, D)
                if (strlen($dbAnswerStr) === 1 && ctype_alpha($dbAnswerStr)) {
                    $correctLetter = strtoupper($dbAnswerStr);
                } else {
                    // If the DB stored the actual option text
                    $options = is_array($mcq->options) ? $mcq->options : json_decode($mcq->options, true) ?? [];
                    // Case-insensitive search for the answer in options
                    $index = false;
                    foreach ($options as $k => $opt) {
                        if (strtolower(trim($opt)) === strtolower($dbAnswerStr)) {
                            $index = $k;
                            break;
                        }
                    }
                    if ($index !== false) {
                        $correctLetter = chr(65 + $index);
                    }
                }

                if ($correctLetter === $studentAnswerStr || strtolower($studentAnswerStr) === strtolower($dbAnswerStr)) {
                    $correctCount++;
                }
            }
        }

        $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;
        $passThreshold = ($courseSubject->pass_marks / ($courseSubject->total_marks ?: 1) * 100);
        $status = ($score >= $passThreshold) ? 'pass' : 'fail';

        $result = ExamResult::updateOrCreate([
            'user_id'           => $user->id,
            'course_subject_id' => $course_subject_id,
        ], [
            'total_questions'   => $totalQuestions,
            'correct_answers'   => $correctCount,
            'score'             => $score,
            'status'            => $status,
            'student_answers'   => $answers,
            'reattempt_status'  => null,
        ]);

        // Automatically issue certificate if passed
        if ($status === 'pass') {
            $enrollment = $user->courses()->where('course_id', $courseSubject->course_id)->first();
            if ($enrollment && !$enrollment->pivot->certificate_no) {
                // Generate a unique certificate number: RK-YEAR-USERID-COURSEID
                $certNo = 'RK-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) . '-' . str_pad($courseSubject->course_id, 3, '0', STR_PAD_LEFT);
                
                $user->courses()->updateExistingPivot($courseSubject->course_id, [
                    'certificate_no' => $certNo
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    });

    Route::post('/exams/{course_subject_id}/request-reattempt', function (Request $request, $course_subject_id) {
        $user = $request->user();
        $result = ExamResult::where('user_id', $user->id)
            ->where('course_subject_id', $course_subject_id)
            ->where('status', 'fail')
            ->first();

        if (!$result) {
            return response()->json(['message' => 'Failed exam result not found.'], 404);
        }

        $result->update(['reattempt_status' => 'requested']);

        return response()->json(['success' => true, 'message' => 'Reattempt request sent to admin.']);
    });


    Route::get('/exams/{id}/result', function (Request $request, $id) {
        $user = $request->user();
        try {
            // First try finding by ExamResult ID, then by course_subject_id
            $result = ExamResult::with(['courseSubject.mcqs'])->find($id);
            if (!$result) {
                $result = ExamResult::with(['courseSubject.mcqs'])
                    ->where('user_id', $user->id)
                    ->where('course_subject_id', $id)
                    ->latest()
                    ->first();
            }

            if (!$result) {
                return response()->json(['message' => 'Exam result record not found.'], 404);
            }
            
            if ($result->user_id !== $user->id) {
                return response()->json(['message' => 'Unauthorized access.'], 403);
            }

            // Process questions for detailed review on frontend
            $studentAnswers = $result->student_answers ?? [];
            $reviewQuestions = [];

            foreach ($result->courseSubject->mcqs as $mcq) {
                $userAns = $studentAnswers[$mcq->id] ?? ($studentAnswers[(string)$mcq->id] ?? null);
                
                $dbAnswerStr = trim((string)$mcq->answer);
                $correctLetter = null;
                
                if (strlen($dbAnswerStr) === 1 && ctype_alpha($dbAnswerStr)) {
                    $correctLetter = strtoupper($dbAnswerStr);
                } else {
                    $options = is_array($mcq->options) ? $mcq->options : json_decode($mcq->options, true) ?? [];
                    $index = false;
                    foreach ($options as $k => $opt) {
                        if (strtolower(trim($opt)) === strtolower($dbAnswerStr)) {
                            $index = $k;
                            break;
                        }
                    }
                    if ($index !== false) {
                        $correctLetter = chr(65 + $index);
                    }
                }
                
                $isCorrect = false;
                if ($userAns !== null) {
                    $userAnsStr = strtoupper(trim((string)$userAns));
                    if ($correctLetter === $userAnsStr || strtolower($userAnsStr) === strtolower($dbAnswerStr)) {
                        $isCorrect = true;
                    }
                }
                
                $status = 'unanswered';
                if ($userAns !== null) {
                    $status = $isCorrect ? 'correct' : 'incorrect';
                }

                $reviewQuestions[] = [
                    'id' => $mcq->id,
                    'text' => $mcq->question,
                    'correct_answer' => $mcq->answer,
                    'user_selection' => $userAns,
                    'status' => $status,
                    'options' => collect($mcq->options)->map(function($opt, $index) {
                        return [
                            'label' => chr(65 + $index),
                            'text' => $opt
                        ];
                    })
                ];
            }

            // Explicitly include course_id for certificate generation
            $result->course_id = $result->courseSubject->course_id;

            return response()->json([
                'success' => true,
                'result' => $result,
                'questions' => $reviewQuestions,
                'course_id' => $result->course_id
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    });

    Route::post('/video-completion', function (Request $request) {
        $user = $request->user();
        $request->validate([
            'video_id' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        \App\Models\VideoCompletion::updateOrCreate(
            ['user_id' => $user->id, 'video_id' => $request->video_id],
            ['course_id' => $request->course_id, 'is_completed' => true]
        );

        return response()->json(['success' => true]);
    });

    Route::get('/certificate/{course_id}/download', function($course_id) {
        $controller = new App\Http\Controllers\Student\DashboardController();
        $response = $controller->downloadCertificate($course_id);
        
        // Add CORS headers for web access
        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', '*');
        }
        
        return $response;
    });

    Route::get('/marksheet/{course_id}/download', function($course_id) {
        $controller = new App\Http\Controllers\Student\DashboardController();
        $response = $controller->downloadMarksheet($course_id);
        
        // Add CORS headers for web access
        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', '*');
        }
        
        return $response;
    });
});
