<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function checkout(Course $course)
    {
        // Explicitly check for auth (though middleware should handle it)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to continue checkout.');
        }

        $user = Auth::user();

        // Check if student is already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.learning', $course->id)->with('info', 'You already enrolled in this course.');
        }

        return view('client.checkout', compact('user', 'course'));
    }

    /**
     * Handle the course purchase request.
     */
    public function purchaseCourse(Request $request, Course $course)
    {
        $user = Auth::user();

        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('info', 'You already enrolled in this course.');
        }
        $paymentMethod = $request->payment_method;
        if ($paymentMethod === 'online') {
            // Simulated Success Redirect for now since user has no key
            return redirect()->route('student.courses.payment.success', ['course_id' => $course->id]);
        }
        // Offline Enrollment Request
        $user->courses()->attach($course->id, [
            'payment_method' => 'offline',
            'amount' => $course->price,
            'status' => 'pending'
        ]);
        return redirect()->route('student.dashboard')->with('offline_success', true);
    }

    /**
     * Handle payment success callback.
     */
    public function paymentSuccess(Request $request, \App\Services\ReceiptService $receiptService)
    {
        $user = Auth::user();
        $courseId = $request->course_id;
        $course = Course::findOrFail($courseId);
        
        $enrollment = DB::table('course_user')
            ->where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            $enrollmentId = DB::table('course_user')->insertGetId([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'payment_method' => 'online',
                'amount' => $course->price,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Generate and send receipt
            $receiptService->generateAndSend($user, $course, $enrollmentId);
        }

        return view('client.payment-success', compact('course'));
    }
}
