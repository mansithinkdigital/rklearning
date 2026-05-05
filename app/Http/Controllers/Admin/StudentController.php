<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Course;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['courses' => function ($query) {
                $query->withPivot('created_at');
            }]);

        // Apply Filters to the table view
        if ($request->filled('course_id')) {
            $query->whereHas('courses', function($q) use ($request) {
                $q->where('courses.id', $request->course_id);
            });
        }

        if ($request->filled('year')) {
            $query->whereHas('courses', function($q) use ($request) {
                $q->whereYear('course_user.created_at', $request->year);
            });
        }

        if ($request->filled('from_date')) {
            $query->whereHas('courses', function($q) use ($request) {
                $q->whereDate('course_user.created_at', '>=', $request->from_date);
            });
        }

        if ($request->filled('to_date')) {
            $query->whereHas('courses', function($q) use ($request) {
                $q->whereDate('course_user.created_at', '<=', $request->to_date);
            });
        }

        $students = $query->latest()->get();
        $branches = Branch::all();
        $allCourses = Course::all();

        return view('admin.pages.student.index', compact('students', 'branches', 'allCourses'));
    }

    public function export(Request $request)
    {
        $query = DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
            ->select(
                'users.name as student_name',
                'users.email',
                'users.phone',
                'courses.name as course_name',
                'courses.duration',
                'branches.branch_name',
                'course_user.created_at as purchase_date'
            )
            ->where('users.role', 'student');

        // Apply same filters as index
        if ($request->filled('course_id')) {
            $query->where('course_user.course_id', $request->course_id);
        }

        if ($request->filled('year')) {
            $query->whereYear('course_user.created_at', $request->year);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('course_user.created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('course_user.created_at', '<=', $request->to_date);
        }

        $data = $query->latest('course_user.created_at')->get();

        // Process data for export
        $processedData = $data->map(function ($item) {
            $purchaseDate = Carbon::parse($item->purchase_date);
            $expiryDate = $this->calculateExpiry($item->purchase_date, $item->duration);

            return [
                'Student Name' => $item->student_name,
                'Email' => $item->email,
                'Phone' => $item->phone,
                'Branch' => $item->branch_name ?? 'N/A',
                'Course' => $item->course_name,
                'Purchase Year' => $purchaseDate->format('Y'),
                'Enrollment Date' => $purchaseDate->format('d-m-Y'),
                'Expiry Date' => $expiryDate ? $expiryDate->format('d-m-Y') : 'N/A',
            ];
        });

        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.pages.student.export_pdf', ['data' => $processedData]);
            return $pdf->download('students_export_' . now()->format('Y-m-d') . '.pdf');
        }

        // CSV/Excel Export
        $filename = "students_export_" . now()->format('Y-m-d') . ".csv";
        $handle = fopen('php://memory', 'w');
        
        // UTF-8 BOM for Excel compatibility
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        if ($processedData->count() > 0) {
            fputcsv($handle, array_keys($processedData->first()));
            foreach ($processedData as $row) {
                fputcsv($handle, $row);
            }
        } else {
            fputcsv($handle, ['No data found matching current filters']);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ]);
    }

    private function calculateExpiry($startDate, $duration)
    {
        if (!$duration) return null;

        $carbonDate = Carbon::parse($startDate);

        if (preg_match('/(\d+)\s*(month|year)/i', $duration, $matches)) {
            $value = (int)$matches[1];
            $unit = strtolower($matches[2]);

            if (str_contains($unit, 'month')) {
                return $carbonDate->addMonths($value);
            } elseif (str_contains($unit, 'year')) {
                return $carbonDate->addYears($value);
            }
        }

        return null;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($student->id),
            ],
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'branch_id' => 'required|exists:branches,id',
            'new_password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'branch_id' => $request->branch_id,
        ];

        // Only update password if admin provided a new one
        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        $student->update($data);

        return back()->with('success', 'Student details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return back()->with('success', 'Student deleted successfully.');
    }

    public function previewCertificate($user_id, $course_id)
    {
        $user = User::findOrFail($user_id);
        $course = Course::findOrFail($course_id);

        $enrollment = $user->courses()->where('courses.id', $course_id)->first();
        if (!$enrollment) {
            return back()->with('error', 'Student not enrolled in this course.');
        }

        $userPhotoBase64 = null;
        if ($user->image && file_exists(public_path($user->image))) {
            $path = public_path($user->image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $userPhotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $enrollDate = optional($enrollment->pivot->created_at)->format('d/m/Y') ?? 'N/A';
        
        // Use the StudentDashboardController's logic for generating/ensuring cert no
        $dashboardController = new \App\Http\Controllers\Student\DashboardController();
        $certificateNo = $dashboardController->ensureCertificateNo($user, $course);

        return view('student.exams.certificate_print', compact('user', 'course', 'userPhotoBase64', 'enrollDate', 'certificateNo'));
    }

    public function previewMarksheet($user_id, $course_id)
    {
        $user = User::findOrFail($user_id);
        $course = Course::findOrFail($course_id);

        $enrollment = $user->courses()->where('courses.id', $course_id)->first();
        if (!$enrollment) {
            return back()->with('error', 'Student not enrolled in this course.');
        }

        $subjects = \App\Models\CourseSubject::where('course_id', $course->id)->with('subject')->get();
        $results = \App\Models\ExamResult::where('user_id', $user->id)
            ->whereIn('course_subject_id', $subjects->pluck('id'))
            ->get()
            ->keyBy('course_subject_id');

        $userPhotoBase64 = null;
        if ($user->image && file_exists(public_path($user->image))) {
            $path = public_path($user->image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $userPhotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $enrollDate = optional($enrollment->pivot->created_at)->format('d/m/Y') ?? 'N/A';

        return view('student.exams.marksheet_print', compact('user', 'course', 'subjects', 'results', 'enrollDate', 'userPhotoBase64'));
    }
}
