<?php

namespace App\Services;

use App\Mail\CourseReceiptMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReceiptService
{
    /**
     * Generate and send receipt for a course enrollment.
     */
    public function generateAndSend($user, $course, $enrollmentId, $amount = null, $balance = null)
    {
        $enrollment = DB::table('course_user')->where('id', $enrollmentId)->first();
        
        // Reuse existing receipt number if available, otherwise generate new one based on Registration ID (User ID)
        if (!empty($enrollment->receipt_no)) {
            $receiptNo = $enrollment->receipt_no;
        } else {
            $receiptNo = 'RK-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) . '-' . str_pad($enrollmentId, 4, '0', STR_PAD_LEFT);
        }
        $date = date('d / m / Y');
        
        // Use provided amount/balance or fallback to enrollment record
        $paidAmount = $amount ?? ($enrollment->paid_amount ?? $enrollment->amount ?? $course->price);
        $balanceAmount = $balance ?? ($enrollment->balance_amount ?? 0);
        
        $studentName = $user->name;
        $courseName = $course->name;
        $paymentMethod = $enrollment->payment_method ?? 'N/A';
        $branchName = $user->branch ? $user->branch->branch_name : 'N/A';

        $data = [
            'receipt_no' => $receiptNo,
            'date' => $date,
            'amount' => $paidAmount,
            'balance_amount' => $balanceAmount,
            'student_name' => $studentName,
            'course_name' => $courseName,
            'payment_method' => strtoupper($paymentMethod),
            'branch_name' => $branchName,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('admin.pages.receipt.template', $data);
        
        $filename = 'Receipt_' . $receiptNo . '_' . time() . '.pdf';
        $relativeDir = 'admin/uploads/receipt';
        $fullPath = public_path($relativeDir . '/' . $filename);
        
        // Ensure directory exists
        if (!file_exists(public_path($relativeDir))) {
            mkdir(public_path($relativeDir), 0755, true);
        }

        // Save file
        $pdf->save($fullPath);

        $receiptPath = $relativeDir . '/' . $filename;

        // Save to enrollment_receipts table for history
        DB::table('enrollment_receipts')->insert([
            'enrollment_id' => $enrollmentId,
            'receipt_no' => $receiptNo,
            'receipt_file' => $receiptPath,
            'amount_paid' => $paidAmount,
            'balance_amount' => $balanceAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update enrollment record (last receipt)
        DB::table('course_user')
            ->where('id', $enrollmentId)
            ->update([
                'receipt_no' => $receiptNo,
                'receipt_file' => $receiptPath,
                'updated_at' => now()
            ]);

        // Send Email
        try {
            Mail::to($user->email)->send(new CourseReceiptMail($user, $course, $receiptPath));
        } catch (\Exception $e) {
            // Log error or handle gracefully
            \Log::error('Receipt Email failed: ' . $e->getMessage());
        }

        return $receiptPath;
    }
}
