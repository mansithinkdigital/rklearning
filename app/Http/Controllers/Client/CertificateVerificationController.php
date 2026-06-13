<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class CertificateVerificationController extends Controller
{
    public function index()
    {
        return view('client.verify_certificate');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'certificate_no' => 'required|string',
        ]);

        $certId = strtoupper(trim($request->certificate_no));
        
        // Search for the certificate in the database
        $enrollment = \DB::table('course_user')
            ->where('certificate_no', $certId)
            ->first();

        if (!$enrollment) {
            // Fallback for old format if necessary, or just fail
            // Let's try to parse it just in case it's an old one (RKYYYYMM-USERID)
            $parts = explode('-', $certId);
            if (count($parts) >= 2) {
                $userId = str_replace('RK', '', $parts[1]);
                $user = User::find($userId);
                if ($user) {
                    $courseId = isset($parts[2]) ? $parts[2] : null;
                    if ($courseId) {
                        $course = Course::find($courseId);
                        if ($course && $user->checkCourseCompletion($course)) {
                            $courses = collect([$course]);
                        }
                    } else {
                        $courses = collect();
                        foreach ($user->courses()->wherePivot('status', 'approved')->get() as $c) {
                            if ($user->checkCourseCompletion($c)) {
                                $courses->push($c);
                            }
                        }
                    }
                }
            }

            if (!isset($user) || $courses->isEmpty()) {
                return back()->with('error', 'Certificate not found or invalid.');
            }
        } else {
            $user = User::find($enrollment->user_id);
            $course = Course::find($enrollment->course_id);
            if (!$user || !$course) {
                return back()->with('error', 'Certificate data is corrupted.');
            }
            $courses = collect([$course]);
        }

        // For display, we'll use the first one found if not specified
        $course = $courses->first();

        // Get enroll date
        $enrollment = $user->courses()->where('courses.id', $course->id)->first();
        $enrollDate = optional($enrollment->pivot->created_at)->format('d/m/Y') ?? 'N/A';

        // Prepare photo
        $userPhotoBase64 = null;
        if ($user->image && file_exists(public_path($user->image))) {
            $path = public_path($user->image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $userPhotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        return view('client.verify_certificate', compact('user', 'course', 'enrollDate', 'userPhotoBase64', 'certId'));
    }
}
