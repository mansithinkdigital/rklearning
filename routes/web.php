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
use App\Http\Controllers\Admin\CourseMcqController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('signIn');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'register']); // Temporary route to seed admin
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
        // ------------------VACANCY----------------------------------//
        Route::resource('vacancy', VacancyController::class);
        // ------------------COURSE SUBJECT & MCQ------------------------//
        Route::resource('course-subject', \App\Http\Controllers\Admin\CourseSubjectController::class);
        Route::get('/get-subjects/{course_id}', [\App\Http\Controllers\Admin\CourseSubjectController::class, 'getSubjects'])->name('course-subject.get-subjects');
        
        Route::get('course-subject/{courseSubject}/mcqs', [\App\Http\Controllers\Admin\CourseMcqController::class, 'index'])->name('course-subject.mcqs.manage');
        Route::post('course-subject/{courseSubject}/mcqs', [\App\Http\Controllers\Admin\CourseMcqController::class, 'store'])->name('course-subject.mcqs.store');
        Route::put('course-mcq/{courseMcq}', [\App\Http\Controllers\Admin\CourseMcqController::class, 'update'])->name('course-mcq.update');
        Route::delete('course-mcq/{courseMcq}', [\App\Http\Controllers\Admin\CourseMcqController::class, 'destroy'])->name('course-mcq.destroy');
        
        // ------------------SUBJECT MCQ----------------------------------//
        Route::get('subject/{subject}/mcqs', [\App\Http\Controllers\Admin\SubjectMcqController::class, 'index'])->name('subject.mcqs.manage');
        Route::post('subject/{subject}/mcqs', [\App\Http\Controllers\Admin\SubjectMcqController::class, 'storeMultiple'])->name('subject.mcqs.storeMultiple');
        // -------------------------------------------------------------//
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
