<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\FreePdfController;
use App\Http\Controllers\Admin\FreeVideoController;

use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VacancyController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\CourseMcqController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use \App\Http\Controllers\Admin\CourseSubjectController;
use \App\Http\Controllers\Admin\SubjectMcqController;
use \App\Http\Controllers\Admin\StudentController;
use  \App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CourseContentController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\CertificateVerificationController;



Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
Route::get('/courses/{course}', [HomeController::class, 'courseDetail'])->name('courses.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/verify-certificate', [CertificateVerificationController::class, 'index'])->name('certificate.verify');
Route::post('/verify-certificate', [CertificateVerificationController::class, 'verify'])->name('certificate.verify.submit');


Route::get('/login', [StudentAuthController::class, 'loginForm'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/register', [StudentAuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [StudentAuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [StudentAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-courses', [StudentDashboardController::class, 'courses'])->name('my-courses');
        Route::get('/courses/{course}/checkout', [CheckoutController::class, 'checkout'])->name('courses.checkout');
        Route::post('/courses/{course}/purchase', [CheckoutController::class, 'purchaseCourse'])->name('courses.purchase');
        Route::post('/courses/{course}/verify-payment', [CheckoutController::class, 'verifyPayment'])->name('courses.verify-payment');
        Route::get('/payment-success', [CheckoutController::class, 'paymentSuccess'])->name('courses.payment.success');
        Route::get('/payment-failed', [CheckoutController::class, 'paymentFailed'])->name('courses.payment.failed');
        Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [StudentDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/my-courses/{course_id}', [StudentDashboardController::class, 'learning'])->name('learning');
        Route::get('/exams', [StudentDashboardController::class, 'exams'])->name('exams');
        Route::get('/exams/{course_subject_id}/start', [StudentDashboardController::class, 'startExam'])->name('exams.start');
        Route::post('/exams/{course_subject_id}/submit', [StudentDashboardController::class, 'submitExam'])->name('exams.submit');
        Route::get('/exams/{course_subject_id}/result', [StudentDashboardController::class, 'viewResult'])->name('exams.result');
        Route::get('/courses/{course_id}/certificate', [StudentDashboardController::class, 'downloadCertificate'])->name('certificate.download');
        Route::get('/courses/{course_id}/certificate/preview', [StudentDashboardController::class, 'previewCertificate'])->name('certificate.preview');
        Route::get('/courses/{course_id}/marksheet', [StudentDashboardController::class, 'downloadMarksheet'])->name('marksheet.download');
        Route::get('/courses/{course_id}/marksheet/preview', [StudentDashboardController::class, 'previewMarksheet'])->name('marksheet.preview');
        Route::get('/certificates', [StudentDashboardController::class, 'certificates'])->name('certificates');
        Route::post('/videos/{video_id}/complete', [StudentDashboardController::class, 'markVideoCompleted'])->name('videos.complete');
        Route::get('/fee-history', [StudentDashboardController::class, 'financials'])->name('financials');
        Route::get('/receipt/{reference}', [StudentDashboardController::class, 'downloadReceipt'])->name('receipt.download');
        // Free Content & Study Material
        Route::get('/free-videos', [StudentDashboardController::class, 'freeVideos'])->name('free-videos');
        Route::get('/free-pdfs', [StudentDashboardController::class, 'freePdfs'])->name('free-pdfs');
        Route::get('/study-material', [StudentDashboardController::class, 'studyMaterial'])->name('study-material');
        Route::post('/exams/{course_subject_id}/request-reattempt', [StudentDashboardController::class, 'requestReattempt'])->name('exams.request-reattempt');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('signIn');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'register'])->name('register'); // Temporary route to seed admin
    //----------------- Admin Authentication -----------------//
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // --------------------branch-----------------------------------//
        Route::resource('branch', BranchController::class);
        // ------------------COURSE-----------------------------------//
        Route::resource('course', CourseController::class);
        Route::get('course/{course}/manage', [CourseContentController::class, 'manage'])->name('course.manage');
        // ------------------SUBJECT-----------------------------------//
        Route::resource('subject', SubjectController::class);
        // ------------------UNIT-----------------------------------//
        Route::resource('unit', UnitController::class);
        Route::get('subject/{subject}/units', [UnitController::class, 'index'])->name('subject.units.index');
        // ------------------TOPIC-----------------------------------//
        Route::resource('topic', TopicController::class);
        Route::get('unit/{unit}/topics', [TopicController::class, 'index'])->name('unit.topics.index');
        // ------------------FREE PDF-----------------------------------//
        Route::resource('free-pdf', FreePdfController::class);
        // ------------------FREE VIDEO----------------------------------//
        Route::resource('free-video', FreeVideoController::class);
        // ------------------GALLERY----------------------------------//
        Route::resource('gallery', GalleryController::class);
        // ------------------STUDENT----------------------------------//
        Route::resource('student', StudentController::class);
        Route::get('/student-export', [StudentController::class, 'export'])->name('student.export');
        Route::get('/student/{user}/course/{course}/certificate', [StudentController::class, 'previewCertificate'])->name('student.certificate.preview');
        Route::get('/student/{user}/course/{course}/marksheet', [StudentController::class, 'previewMarksheet'])->name('student.marksheet.preview');
        Route::get('/student/{user}/results', [\App\Http\Controllers\Admin\ExamResultController::class, 'studentResults'])->name('student.results');
        // ------------------VACANCY----------------------------------//
        Route::resource('vacancy', VacancyController::class);
        // ------------------TESTIMONIAL------------------------------//
        Route::resource('testimonial', TestimonialController::class);
        // ------------------COURSE SUBJECT & MCQ------------------------//
        Route::resource('course-subject', CourseSubjectController::class);
        Route::get('/get-subjects/{course_id}', [CourseSubjectController::class, 'getSubjects'])->name('course-subject.get-subjects');
        Route::get('/get-units-by-subject/{subject_id}', [FreePdfController::class, 'getUnits'])->name('get-units-by-subject');
        Route::get('course-subject/{courseSubject}/mcqs', [CourseMcqController::class, 'index'])->name('course-subject.mcqs.manage');
        Route::post('course-subject/{courseSubject}/mcqs', [CourseMcqController::class, 'store'])->name('course-subject.mcqs.store');
        Route::put('course-mcq/{courseMcq}', [CourseMcqController::class, 'update'])->name('course-mcq.update');
        Route::delete('course-mcq/{courseMcq}', [CourseMcqController::class, 'destroy'])->name('course-mcq.destroy');
        // ------------------SUBJECT MCQ----------------------------------//
        Route::get('subject/{subject}/mcqs', [SubjectMcqController::class, 'index'])->name('subject.mcqs.manage');
        Route::post('subject/{subject}/mcqs', [SubjectMcqController::class, 'storeMultiple'])->name('subject.mcqs.storeMultiple');
        // ------------------ENROLLMENTS-------------------------------//
        // ------------------ENROLLMENTS & PAYMENTS-------------------------------//
        Route::get('/enrollments', [\App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/payments/online', [\App\Http\Controllers\Admin\EnrollmentController::class, 'onlinePayments'])->name('payments.online');
        Route::get('/payments/offline', [\App\Http\Controllers\Admin\EnrollmentController::class, 'offlinePayments'])->name('payments.offline');
        Route::post('/payments/offline/{id}/update', [\App\Http\Controllers\Admin\EnrollmentController::class, 'updateOfflinePayment'])->name('payments.offline.update');
        Route::post('/payments/offline/{id}/toggle-status', [\App\Http\Controllers\Admin\EnrollmentController::class, 'toggleStatus'])->name('payments.offline.toggle-status');
        Route::post('/enrollments/{user}/{course}/approve', [\App\Http\Controllers\Admin\EnrollmentController::class, 'approve'])->name('enrollments.approve');
        Route::delete('/enrollments/{user}/{course}', [\App\Http\Controllers\Admin\EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
        // ------------------EXAM RESULTS-------------------------------//
        Route::get('/exam-results', [\App\Http\Controllers\Admin\ExamResultController::class, 'index'])->name('exam-results.index');
        Route::get('/exam-results/{id}', [\App\Http\Controllers\Admin\ExamResultController::class, 'show'])->name('exam-results.show');
        Route::post('/exam-results/{id}/allow-reattempt', [\App\Http\Controllers\Admin\ExamResultController::class, 'allowReattempt'])->name('exam-results.allow-reattempt');
        // -------------------------------------------------------------//
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/preview/certificate-demo', function () {
    $user = (object)[
        'name' => 'DARSHANA SHARAD SONJE',
        'father_name' => 'SHARAD JAGANNATH SONJE',
        'mother_name' => 'PUSHPA',
        'id' => 9999,
        'branch' => (object)['name' => 'Gangapur Road, Nashik']
    ];
    $course = (object)['name' => 'Diploma in Accounting with Taxation', 'id' => 1];
    $enrollDate = '01/04/2026';
    $userPhotoBase64 = null;

    return view('student.exams.certificate_print', compact('user', 'course', 'enrollDate', 'userPhotoBase64'));
});

Route::get('/preview/marksheet-demo', function () {
    $user = (object)[
        'name' => 'DARSHANA SHARAD SONJE',
        'father_name' => 'SHARAD JAGANNATH SONJE',
        'mother_name' => 'PUSHPA',
        'id' => 9999,
    ];
    $course = (object)['name' => 'Diploma in Accounting with Taxation', 'id' => 1];
    
    $subjects = collect([
        (object)['id' => 1, 'total_marks' => 100, 'pass_marks' => 40, 'subject' => (object)['name' => 'Financial Accounting']],
        (object)['id' => 2, 'total_marks' => 100, 'pass_marks' => 40, 'subject' => (object)['name' => 'Tally Prime']],
        (object)['id' => 3, 'total_marks' => 100, 'pass_marks' => 40, 'subject' => (object)['name' => 'Goods and Services Tax (GST)']],
        (object)['id' => 4, 'total_marks' => 100, 'pass_marks' => 40, 'subject' => (object)['name' => 'Income Tax']],
        (object)['id' => 5, 'total_marks' => 100, 'pass_marks' => 40, 'subject' => (object)['name' => 'Fundamentals of Computer']],
        (object)['id' => 6, 'total_marks' => 100, 'pass_marks' => 40, 'subject' => (object)['name' => 'MS Excel']],
    ]);

    $results = collect([
        1 => (object)['score' => 90, 'status' => 'pass'],
        2 => (object)['score' => 92, 'status' => 'pass'],
        3 => (object)['score' => 80, 'status' => 'pass'],
        4 => (object)['score' => 78, 'status' => 'pass'],
        5 => (object)['score' => 88, 'status' => 'pass'],
        6 => (object)['score' => 76, 'status' => 'pass'],
    ]);

    $enrollDate = '01/04/2026';
    $userPhotoBase64 = null;

    return view('student.exams.marksheet_print', compact('user', 'course', 'subjects', 'results', 'enrollDate', 'userPhotoBase64'));
});
