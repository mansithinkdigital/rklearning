<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\FreeVideo;
use App\Models\Freepdf;
use App\Models\PaidVideo;
use App\Models\Topic;
use App\Models\CourseSubject;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    /**
     * Display student dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Fetch approved courses
        $enrolledCourses = $user->courses()
            ->wherePivot('status', 'approved')
            ->withCount('subjects')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($course) {
                $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
                $course->expiry_date = $this->calculateExpiryDate($startDate, $course->duration);
                $course->days_remaining = $course->expiry_date ? now()->diffInDays($course->expiry_date, false) : 0;
                $course->is_expired = $course->expiry_date && $course->expiry_date->isPast();
                return $course;
            });

        // Fetch free contents for dashboard quick access
        $freeVideosCount = FreeVideo::count();
        $freePdfsCount = Freepdf::count();

        // Fetch pending (offline) requests
        $pendingRequests = $user->courses()
            ->wherePivot('status', 'pending')
            ->latest()
            ->get();

        $activeCoursesCount = $enrolledCourses->where('is_expired', false)->count();
        $certificatesCount = 0;
        $attendancePercentage = 100;
        $latestCourse = $enrolledCourses->where('is_expired', false)->first();

        $announcements = [];
        if ($enrolledCourses->isNotEmpty()) {
            $announcements[] = [
                'type' => 'exam',
                'label' => 'Exam',
                'title' => "Quiz Available for {$latestCourse->name}",
                'description' => 'One of your enrolled courses has a new assessment ready. Stay ahead with the latest lesson.',
                'date' => now()->addDays(3)->format('M d, Y'),
                'link' => route('student.exams'),
                'linkLabel' => 'Go to Quiz',
            ];
        }

        // Fetch actual transactions from enrollment pivot table
        $recentPayments = $this->getRealPaymentHistory($user, 5);

        $totalPaid = $recentPayments->where('status', 'Approved')->sum('amount');
        $pendingFees = $recentPayments->where('status', 'Pending')->sum('amount');

        return view('student.dashboard', compact(
            'user',
            'enrolledCourses',
            'pendingRequests',
            'activeCoursesCount',
            'certificatesCount',
            'attendancePercentage',
            'announcements',
            'recentPayments',
            'pendingFees',
            'latestCourse',
            'freeVideosCount',
            'freePdfsCount'
        ));
    }

    /**
     * Display enrolled courses.
     */
    public function courses()
    {
        $user = Auth::user();
        
        // Fetch approved courses
        $enrolledCourses = $user->courses()
            ->wherePivot('status', 'approved')
            ->withCount('subjects')
            ->with('paidVideos')
            ->get()
            ->map(function($course) {
                $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
                $course->expiry_date = $this->calculateExpiryDate($startDate, $course->duration);
                $course->days_remaining = $course->expiry_date ? now()->diffInDays($course->expiry_date, false) : 0;
                $course->is_expired = $course->expiry_date && $course->expiry_date->isPast();
                return $course;
            });

        // Fetch pending (offline) requests
        $pendingCourses = $user->courses()
            ->wherePivot('status', 'pending')
            ->withCount('subjects')
            ->get();

        $availableCourses = Course::where('status', 'Active')
            ->whereNotIn('id', $user->courses()->pluck('course_id')->toArray())
            ->latest()
            ->get();

        return view('student.courses.index', compact('user', 'enrolledCourses', 'pendingCourses', 'availableCourses'));
    }

    /**
     * Display student profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $path = public_path('student/uploads/registerimg');
            
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $image->move($path, $imageName);
            $imagePath = 'student/uploads/registerimg/' . $imageName;
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function learning($course_id)
    {
        $user = Auth::user();
        $course = Course::with([
            'subjects.units.topics',
            'subjects.units.paidVideos',
            'subjects.units.freePdfs'
        ])->findOrFail($course_id);

        // Access Control: Check Expiry
        $enrollment = $user->courses()->where('course_id', $course_id)->first();
        if ($enrollment) {
            $startDate = $enrollment->pivot->updated_at ?? $enrollment->pivot->created_at;
            $expiryDate = $this->calculateExpiryDate($startDate, $enrollment->duration);
            if ($expiryDate && $expiryDate->isPast()) {
                return redirect()->route('student.courses')->with('error', 'Your access to this course has expired.');
            }
        }
        
        $allVideos = \App\Models\PaidVideo::where('course_id', $course_id)
            ->orderBy('id', 'asc')
            ->get();

        $completedVideoIds = \App\Models\VideoCompletion::where('user_id', $user->id)
            ->where('course_id', $course_id)
            ->pluck('video_id')
            ->toArray();
        
        return view('student.learning.player', compact('user', 'course', 'completedVideoIds', 'allVideos'));
    }

    public function exams()
    {
        $user = Auth::user();
        
        // Fetch only non-expired enrolled courses
        $enrolledCourses = $user->courses()
            ->wherePivot('status', 'approved')
            ->get()
            ->map(function($course) use ($user) {
                $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
                $course->expiry_date = $this->calculateExpiryDate($startDate, $course->duration);
                $course->is_expired = $course->expiry_date && $course->expiry_date->isPast();
                
                // Check if course is fully completed (all exams passed)
                $subjects = \App\Models\CourseSubject::where('course_id', $course->id)->get();
                $course->is_fully_completed = false;
                if ($subjects->isNotEmpty()) {
                    $passedCount = ExamResult::where('user_id', $user->id)
                        ->whereIn('course_subject_id', $subjects->pluck('id'))
                        ->where('status', 'pass')
                        ->count();
                    $course->is_fully_completed = ($passedCount === $subjects->count());
                }
                
                return $course;
            });
        
        $courseSubjects = \App\Models\CourseSubject::whereIn('course_id', $enrolledCourses->pluck('id'))
            ->with(['subject', 'course', 'mcqs'])
            ->get()
            ->map(function($cs) use ($enrolledCourses, $user) {
                $parentCourse = $enrolledCourses->firstWhere('id', $cs->course_id);
                $cs->is_expired = $parentCourse ? $parentCourse->is_expired : false;
                
                // Check Video Progress
                $totalVideos = \App\Models\PaidVideo::where('course_id', $cs->course_id)->count();
                $completedVideos = \App\Models\VideoCompletion::where('user_id', $user->id)
                    ->where('course_id', $cs->course_id)
                    ->count();

                $cs->videos_completed = ($totalVideos > 0) && ($completedVideos >= $totalVideos);
                if ($totalVideos === 0) $cs->videos_completed = true;
                
                $cs->video_count = $totalVideos;
                $cs->completed_count = $completedVideos;
                $cs->progress_percent = ($totalVideos > 0) ? round(($completedVideos / $totalVideos) * 100) : 100;
                
                return $cs;
            });

        // Attach results if any
        foreach($courseSubjects as $cs) {
            $cs->result = ExamResult::where('user_id', $user->id)
                ->where('course_subject_id', $cs->id)
                ->first();
        }

        return view('student.exams.index', compact('user', 'courseSubjects', 'enrolledCourses'));
    }

    public function startExam($course_subject_id)
    {
        $user = Auth::user();
        $courseSubject = CourseSubject::with(['course', 'subject', 'mcqs'])->findOrFail($course_subject_id);

        // Security Check: Is student enrolled?
        $isEnrolled = $user->courses()->where('courses.id', $courseSubject->course_id)->exists();
        if (!$isEnrolled) {
            return redirect()->route('student.exams')->with('error', 'Unauthorized access.');
        }

        // Check Video Completion
        $totalVideos = \App\Models\PaidVideo::where('course_id', $courseSubject->course_id)->count();
        $completedVideos = \App\Models\VideoCompletion::where('user_id', $user->id)
            ->where('course_id', $courseSubject->course_id)
            ->count();

        if ($totalVideos > 0 && $completedVideos < $totalVideos) {
            return redirect()->route('student.exams')->with('error', 'You must complete all video lessons before starting the exam.');
        }

        // Check if exam already taken
        $previousResult = ExamResult::where('user_id', $user->id)
            ->where('course_subject_id', $course_subject_id)
            ->first();
        
        if ($previousResult) {
            return redirect()->route('student.exams')->with('error', 'You have already completed this examination.');
        }

        if ($courseSubject->mcqs->isEmpty()) {
            return redirect()->route('student.exams')->with('error', 'No questions available for this subject.');
        }

        // Compute time limit: use stored value, or fallback 2 min per question
        $timeLimit = ($courseSubject->time_limit > 0)
            ? $courseSubject->time_limit
            : ($courseSubject->mcqs->count() * 2);

        return view('student.exams.portal', compact('user', 'courseSubject', 'timeLimit'));
    }

    public function markVideoCompleted(Request $request, $video_id)
    {
        $user = Auth::user();
        $video = \App\Models\PaidVideo::findOrFail($video_id);

        // Security: Check if enrolled in the course
        $isEnrolled = $user->courses()->where('courses.id', $video->course_id)->exists();
        if (!$isEnrolled) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Sequential Check: Is there a previous video?
        $allVideos = \App\Models\PaidVideo::where('course_id', $video->course_id)
            ->orderBy('id', 'asc')
            ->get();
        
        $currentIndex = $allVideos->search(fn($v) => $v->id == $video->id);
        
        if ($currentIndex > 0) {
            $prevVideo = $allVideos[$currentIndex - 1];
            $prevCompleted = \App\Models\VideoCompletion::where('user_id', $user->id)
                ->where('video_id', $prevVideo->id)
                ->exists();
            
            if (!$prevCompleted) {
                return response()->json(['success' => false, 'message' => 'Complete previous video first'], 400);
            }
        }

        \App\Models\VideoCompletion::updateOrCreate([
            'user_id' => $user->id,
            'video_id' => $video_id,
        ], [
            'course_id' => $video->course_id,
            'is_completed' => true
        ]);

        return response()->json(['success' => true, 'message' => 'Video marked as completed']);
    }

    public function submitExam(Request $request, $course_subject_id)
    {
        $user = Auth::user();
        $courseSubject = CourseSubject::with('mcqs')->findOrFail($course_subject_id);
        
        // Security Check
        $isEnrolled = $user->courses()->where('courses.id', $courseSubject->course_id)->exists();
        if (!$isEnrolled) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
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
        
        // Handle case where pass_marks might be zero or unset
        if($courseSubject->pass_marks > 0) {
            $status = ($correctCount * ($courseSubject->total_marks / $totalQuestions) >= $courseSubject->pass_marks) ? 'pass' : 'fail';
        } else {
            // Default 40% pass if marks not set properly
            $status = ($score >= 40) ? 'pass' : 'fail';
        }

        $result = ExamResult::create([
            'user_id'           => $user->id,
            'course_subject_id' => $course_subject_id,
            'total_questions'   => $totalQuestions,
            'correct_answers'   => $correctCount,
            'score'             => $score,
            'status'            => $status,
            'student_answers'   => $answers,
        ]);

        $message = $status === 'pass'
            ? "🎉 Congratulations! You passed with {$correctCount}/{$totalQuestions} correct answers ({$score}%)."
            : "❌ You scored {$score}% ({$correctCount}/{$totalQuestions} correct). Better luck next time!";

        if (request()->wantsJson() || request()->header('Accept') === 'application/json') {
            return response()->json([
                'success'  => true,
                'message'  => $message,
                'redirect' => route('student.exams.result', $course_subject_id),
            ]);
        }

        return redirect()->route('student.exams.result', $course_subject_id)->with('success', $message);
    }

    public function viewResult($course_subject_id)
    {
        $user = Auth::user();
        $courseSubject = CourseSubject::with(['course', 'subject', 'mcqs'])->findOrFail($course_subject_id);
        
        $result = ExamResult::where('user_id', $user->id)
            ->where('course_subject_id', $course_subject_id)
            ->first();

        if (!$result) {
            return redirect()->route('student.exams')->with('error', 'Result not found.');
        }

        return view('student.exams.result', compact('user', 'courseSubject', 'result'));
    }

    public function downloadCertificate($course_id)
    {
        $user = Auth::user();
        $course = $user->courses()->where('courses.id', $course_id)->firstOrFail();

        $subjects = \App\Models\CourseSubject::where('course_id', $course->id)->get();
        $passedCount = ExamResult::where('user_id', $user->id)
            ->whereIn('course_subject_id', $subjects->pluck('id'))
            ->where('status', 'pass')
            ->count();

        if ($passedCount < $subjects->count()) {
            return back()->with('error', 'Complete all subject exams first.');
        }

        // Base64 Photo
        $userPhotoBase64 = null;
        if ($user->image && file_exists(public_path($user->image))) {
            $path = public_path($user->image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $userPhotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $enrollDate = $course->pivot->created_at->format('d/m/Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('student.exams.certificate_print', compact('user', 'course', 'userPhotoBase64', 'enrollDate'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download("Certificate_{$course->name}.pdf");
    }

    public function downloadMarksheet($course_id)
    {
        $user = Auth::user();
        $course = $user->courses()->where('courses.id', $course_id)->firstOrFail();

        $subjects = \App\Models\CourseSubject::where('course_id', $course->id)->with('subject')->get();
        $results = ExamResult::where('user_id', $user->id)
            ->whereIn('course_subject_id', $subjects->pluck('id'))
            ->get()
            ->keyBy('course_subject_id');

        if ($results->where('status', 'pass')->count() < $subjects->count()) {
            return back()->with('error', 'Complete all subject exams first.');
        }

        // Base64 Photo
        $userPhotoBase64 = null;
        if ($user->image && file_exists(public_path($user->image))) {
            $path = public_path($user->image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $userPhotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $enrollDate = $course->pivot->created_at->format('d/m/Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('student.exams.marksheet_print', compact('user', 'course', 'subjects', 'results', 'enrollDate', 'userPhotoBase64'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download("Marksheet_{$course->name}.pdf");
    }

    /**
     * Display fee history.
     */
    public function financials()
    {
        $user = Auth::user();
        $recentPayments = $this->getRealPaymentHistory($user);

        $totalCourseFee = $user->courses()->sum('price');
        $totalPaid = $recentPayments->where('status', 'Approved')->sum('amount');
        $remainingBalance = max(0, $totalCourseFee - $totalPaid);

        return view('student.financials.index', compact('user', 'recentPayments', 'totalCourseFee', 'totalPaid', 'remainingBalance'));
    }

    public function downloadReceipt($reference)
    {
        $user = Auth::user();
        
        // Extract pivot ID from reference (RK-PAY-XXXXX)
        $pivotId = (int) str_replace('RK-PAY-', '', $reference);

        $enrollment = DB::table('course_user')
            ->where('id', $pivotId)
            ->where('user_id', $user->id)
            ->first();

        if (!$enrollment || !$enrollment->receipt_file) {
            // Fallback: If no PDF yet, generate one on the fly if approved
            if ($enrollment && $enrollment->status === 'approved') {
                $course = Course::find($enrollment->course_id);
                $service = new \App\Services\ReceiptService();
                $receiptPath = $service->generateAndSend($user, $course, $enrollment->id);
                return response()->download(public_path($receiptPath));
            }
            abort(404, 'Receipt not available yet.');
        }

        $filePath = public_path($enrollment->receipt_file);
        
        if (!file_exists($filePath)) {
             abort(404, 'Receipt file physically missing.');
        }

        return response()->download($filePath, "Receipt-{$enrollment->receipt_no}.pdf");
    }

    private function calculateExpiryDate($startDate, $duration)
    {
        if (!$startDate) return null;
        
        $date = \Carbon\Carbon::parse($startDate);
        
        if (!$duration) return $date->addYears(1);
        
        $durationLower = strtolower($duration);
        $amount = (int) filter_var($duration, FILTER_SANITIZE_NUMBER_INT);
        if ($amount <= 0) $amount = 1;

        if (str_contains($durationLower, 'month')) {
            return $date->addMonths($amount);
        } elseif (str_contains($durationLower, 'year')) {
            return $date->addYears($amount);
        } elseif (str_contains($durationLower, 'day')) {
            return $date->addDays($amount);
        }
        
        return $date->addYears(1);
    }

    private function getRealPaymentHistory($user, $limit = null)
    {
        $query = $user->courses()
            ->withPivot('id', 'payment_method', 'amount', 'status', 'created_at')
            ->orderBy('course_user.created_at', 'desc');

        if ($limit) {
            $query->take($limit);
        }

        return $query->get()->map(function($course) {
            $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
            $expiryDate = $this->calculateExpiryDate($startDate, $course->duration);
            $daysLeft = $expiryDate ? now()->diffInDays($expiryDate, false) : 0;

            return [
                'reference' => 'RK-PAY-' . str_pad($course->pivot->id ?? rand(1000, 9999), 5, '0', STR_PAD_LEFT),
                'description' => 'Course Enrollment Fee',
                'id' => $course->pivot->id,
                'course' => $course->name,
                'duration' => $course->duration,
                'method' => strtoupper($course->pivot->payment_method),
                'date' => $course->pivot->created_at ? $course->pivot->created_at->format('d M, Y') : now()->format('d M, Y'),
                'expiry_date' => $expiryDate ? $expiryDate->format('d M, Y') : 'N/A',
                'days_left' => $daysLeft,
                'amount' => $course->pivot->amount,
                'status' => ucfirst($course->pivot->status),
            ];
        });
    }

    public function freeVideos()
    {
        $user = Auth::user();
        $videos = FreeVideo::latest()->get();
        return view('student.free_content.videos', compact('user', 'videos'));
    }

    public function freePdfs()
    {
        $user = Auth::user();
        $pdfs = Freepdf::with('course')->latest()->get();
        return view('student.free_content.pdfs', compact('user', 'pdfs'));
    }

    public function studyMaterial()
    {
        $user = Auth::user();
        // Get courses student has access to
        $enrolledCourseIds = $user->courses()
            ->wherePivot('status', 'approved')
            ->pluck('courses.id');

        // Fetch Study Material from Topics (Subject -> Unit -> Topic)
        $studyMaterials = Topic::whereHas('unit.subject', function($q) use ($enrolledCourseIds) {
                $q->whereIn('course_id', $enrolledCourseIds);
            })
            ->whereNotNull('study_material')
            ->with(['unit.subject.course'])
            ->latest()
            ->get()
            ->filter(function($topic) {
                $course = $topic->unit->subject->course;
                $enrollment = Auth::user()->courses()->where('course_id', $course->id)->first();
                if ($enrollment) {
                    $startDate = $enrollment->pivot->updated_at ?? $enrollment->pivot->created_at;
                    $expiryDate = $this->calculateExpiryDate($startDate, $course->duration);
                    return $expiryDate === null || $expiryDate->isFuture();
                }
                return false;
            });

        return view('student.study_material.index', compact('user', 'studyMaterials'));
    }
}
