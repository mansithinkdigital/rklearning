<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

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
            try {
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

                $orderData = [
                    'receipt'         => 'rcpt_' . time() . '_' . $user->id,
                    'amount'          => $course->price * 100, // amount in the smallest currency unit
                    'currency'        => 'INR',
                    'notes'           => [
                        'course_id' => $course->id,
                        'user_id'   => $user->id,
                    ]
                ];

                $razorpayOrder = $api->order->create($orderData);

                return response()->json([
                    'success' => true,
                    'order_id' => $razorpayOrder['id'],
                    'amount' => $course->price * 100,
                    'name' => $course->name,
                    'description' => 'Enrollment for ' . $course->name,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => $user->phone ?? '',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        // Offline Enrollment Request
        $user->courses()->attach($course->id, [
            'payment_method' => 'offline',
            'amount' => $course->price,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('student.dashboard')->with('offline_success', true);
    }

    /**
     * Verify Razorpay Payment.
     */
    public function verifyPayment(Request $request, Course $course, \App\Services\ReceiptService $receiptService)
    {
        $user = Auth::user();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $success = true;
        $error = "Payment Failed";

        if (!empty($request->razorpay_payment_id)) {
            try {
                $attributes = [
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ];

                $api->utility->verifyPaymentSignature($attributes);
            } catch (\Exception $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        } else {
            $success = false;
        }

        if ($success) {
            // Enroll student
            $enrollmentId = DB::table('course_user')->insertGetId([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'payment_method' => 'online',
                'amount' => $course->price,
                'status' => 'approved',
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate and send receipt
            $receiptService->generateAndSend($user, $course, $enrollmentId);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => $error], 400);
    }

    /**
     * Handle payment success callback.
     */
    public function paymentSuccess(Request $request)
    {
        $courseId = $request->course_id;
        $course = Course::findOrFail($courseId);
        return view('client.payment-success', compact('course'));
    }
}
