<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\CoursePackageController;
use App\Http\Controllers\Admin\FreePdfController;
use App\Http\Controllers\Admin\FreeVideoController;
use App\Http\Controllers\Admin\PaidVideoController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VacancyController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\CourseMcqController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use \App\Http\Controllers\Admin\CourseSubjectController;
use \App\Http\Controllers\Admin\SubjectMcqController;
use \App\Http\Controllers\Admin\StudentController;
use  \App\Http\Controllers\Admin\TestimonialController;


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
Route::get('/courses/{course}', [HomeController::class, 'courseDetail'])->name('courses.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');


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
        Route::post('/courses/{course}/purchase', [StudentDashboardController::class, 'purchaseCourse'])->name('courses.purchase');
        Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [StudentDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/my-courses/{course_id}', [StudentDashboardController::class, 'learning'])->name('learning');
        Route::get('/exams', [StudentDashboardController::class, 'exams'])->name('exams');
        Route::get('/fee-history', [StudentDashboardController::class, 'financials'])->name('financials');
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
        // ------------------SUBJECT-----------------------------------//
        Route::resource('subject', SubjectController::class);
        // ------------------PACKAGE-----------------------------------//
        Route::resource('package', PackageController::class);
        // ------------------COURSE PACKAGE-------------------------//
        Route::resource('course-package', CoursePackageController::class);
        // ------------------FREE PDF-----------------------------------//
        Route::resource('free-pdf', FreePdfController::class);
        // ------------------FREE VIDEO----------------------------------//
        Route::resource('free-video', FreeVideoController::class);
        // ------------------PAID VIDEO----------------------------------//
        Route::resource('paid-video', PaidVideoController::class);
        // ------------------GALLERY----------------------------------//
        Route::resource('gallery', GalleryController::class);
        // ------------------STUDENT----------------------------------//
        Route::resource('student', StudentController::class);
        // ------------------VACANCY----------------------------------//
        Route::resource('vacancy', VacancyController::class);
        // ------------------TESTIMONIAL------------------------------//
        Route::resource('testimonial', TestimonialController::class);
        // ------------------COURSE SUBJECT & MCQ------------------------//
        Route::resource('course-subject', CourseSubjectController::class);
        Route::get('/get-subjects/{course_id}', [CourseSubjectController::class, 'getSubjects'])->name('course-subject.get-subjects');
        Route::get('course-subject/{courseSubject}/mcqs', [CourseMcqController::class, 'index'])->name('course-subject.mcqs.manage');
        Route::post('course-subject/{courseSubject}/mcqs', [CourseMcqController::class, 'store'])->name('course-subject.mcqs.store');
        Route::put('course-mcq/{courseMcq}', [CourseMcqController::class, 'update'])->name('course-mcq.update');
        Route::delete('course-mcq/{courseMcq}', [CourseMcqController::class, 'destroy'])->name('course-mcq.destroy');
        // ------------------SUBJECT MCQ----------------------------------//
        Route::get('subject/{subject}/mcqs', [SubjectMcqController::class, 'index'])->name('subject.mcqs.manage');
        Route::post('subject/{subject}/mcqs', [SubjectMcqController::class, 'storeMultiple'])->name('subject.mcqs.storeMultiple');
        // -------------------------------------------------------------//
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
