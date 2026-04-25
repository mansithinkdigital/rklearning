<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollment requests.
     */
    public function index()
    {
        // Redirect to online payments as default or keep as summary
        return redirect()->route('admin.payments.online');
    }

    public function onlinePayments()
    {
        $onlineEnrollments = DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->select('course_user.*', 'users.name as student_name', 'users.email as student_email', 'courses.name as course_name')
            ->where('payment_method', 'online')
            ->orderBy('course_user.created_at', 'desc')
            ->get();

        return view('admin.pages.enrollment.online', compact('onlineEnrollments'));
    }

    public function offlinePayments()
    {
        $offlineEnrollments = DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->select('course_user.*', 'users.name as student_name', 'users.email as student_email', 'courses.name as course_name', 'courses.price as original_price')
            ->where('payment_method', 'offline')
            ->orderBy('course_user.created_at', 'desc')
            ->get();

        // Fetch receipts for each enrollment
        foreach ($offlineEnrollments as $enrollment) {
            $enrollment->receipts = DB::table('enrollment_receipts')
                ->where('enrollment_id', $enrollment->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.pages.enrollment.offline', compact('offlineEnrollments'));
    }

    public function updateOfflinePayment(Request $request, $id)
    {
        $request->validate([
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'next_installment_date' => 'nullable|date',
        ]);

        $enrollment = DB::table('course_user')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->select('course_user.*', 'courses.price as course_price')
            ->where('course_user.id', $id)
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Enrollment not found.');
        }

        $discountPercent = $request->discount ?? 0;
        $discountAmount = ($enrollment->course_price * $discountPercent) / 100;
        $totalPayable = $enrollment->course_price - $discountAmount;
        $paidAmount = $request->paid_amount;
        $balanceAmount = $totalPayable - $paidAmount;

        DB::table('course_user')
            ->where('id', $id)
            ->update([
                'discount' => $discountPercent,
                'total_payable' => $totalPayable,
                'paid_amount' => $paidAmount,
                'balance_amount' => $balanceAmount,
                'next_installment_date' => $request->next_installment_date,
                'amount' => $paidAmount, // Keep sync with existing 'amount' field
                'updated_at' => now()
            ]);

        // Generate and send receipt for this update
        $user = \App\Models\User::find($enrollment->user_id);
        $course = \App\Models\Course::find($enrollment->course_id);
        $receiptService = app(\App\Services\ReceiptService::class);
        $receiptService->generateAndSend($user, $course, $id, $paidAmount, $balanceAmount);

        return back()->with('success', 'Payment details updated successfully and receipt sent.');
    }

    /**
     * Approve an enrollment request.
     */
    public function approve($userId, $courseId)
    {
        $enrollment = DB::table('course_user')
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment) {
            DB::table('course_user')
                ->where('id', $enrollment->id)
                ->update(['status' => 'approved', 'updated_at' => now()]);
        }

        return back()->with('success', 'Enrollment approved successfully.');
    }

    /**
     * Reject/Delete an enrollment request.
     */
    public function destroy($userId, $courseId)
    {
        DB::table('course_user')
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->delete();

        return back()->with('success', 'Enrollment request rejected and removed.');
    }
}
