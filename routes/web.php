<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\UserArtikelController;
use App\Http\Controllers\SubscribeTransactionController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;

// Public routes
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/details/{course:slug}', [FrontController::class, 'detail'])->name('front.details');
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');
Route::get('/course', [FrontController::class, 'course'])->name('front.course');
Route::get('/article', [UserArtikelController::class, 'index'])->name('artikel.index'); // Article list
Route::get('/article/{slug}', [UserArtikelController::class, 'detail'])->name('artikel.show'); // Article detail
Route::get('/search/course/', [FrontController::class, 'search'])->name('front.search');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teacher-specific routes
    Route::get('/teachers/approval-notice', function () {
        return view('teachers.approval-notice');
    })->name('teachers.approval-notice');



    // Checkout routes
    Route::get('/checkout/{packageId}', [FrontController::class, 'checkout'])->name('front.checkout')
        ->middleware('role:student');

    Route::post('/checkout/store', [FrontController::class, 'checkout_store'])->name('front.checkout.store')
        ->middleware('role:student');

    // Learning system
    Route::get('/learning/{course}/{courseVideoId}', [FrontController::class, 'learning'])->name('front.learning')
        ->middleware('role:student|teacher');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class)
            ->middleware('role:owner');

        Route::resource('teachers', TeacherController::class)
            ->middleware('role:owner');

        Route::get('/teachers/approval', [TeacherController::class, 'approvalRequests'])
            ->middleware('role:owner')
            ->name('teachers.approval');

        Route::put('/teachers/{id}/approve', [TeacherController::class, 'approve'])
            ->middleware('role:owner')
            ->name('admin.teachers.approve');

        Route::delete('/teachers/{id}/reject', [TeacherController::class, 'reject'])
            ->middleware('role:owner')
            ->name('admin.teachers.reject');

        Route::resource('packages', PackageController::class)
            ->middleware('role:owner');

        Route::resource('payments', PaymentController::class)
            ->middleware('role:owner');

        Route::resource('courses', CourseController::class)
            ->middleware('role:owner|teacher');

        Route::resource('subscribe_transactions', SubscribeTransactionController::class)
            ->middleware('role:owner');

        Route::get('/add/video/{course:id}', [CourseVideoController::class, 'create'])
            ->middleware('role:teacher|owner')
            ->name('course.add_video');

        Route::post('/add/video/save/{course:id}', [CourseVideoController::class, 'store'])
            ->middleware('role:teacher|owner')
            ->name('course.add_video.save');

        Route::resource('course_videos', CourseVideoController::class)
            ->middleware('role:owner|teacher');

        Route::resource('artikel', ArtikelController::class)
            ->middleware('role:owner|teacher');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/progress', [FrontController::class, 'progress'])->name('front.progress');
});

// Authentication routes
require __DIR__ . '/auth.php';
