<?php

use App\Http\Controllers\GuidelineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\UserArtikelController;
use App\Http\Controllers\SubscribeTransactionController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\ProvideRejectionReason;

// Public routes
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/details/{course:slug}', [FrontController::class, 'detail'])->name('front.details');
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');
Route::get('/course', [FrontController::class, 'course'])->name('front.course');
Route::get('/article', [UserArtikelController::class, 'index'])->name('artikel.index'); // Article list
Route::get('/article/{slug}', [UserArtikelController::class, 'detail'])->name('artikel.show'); // Article detail
Route::get('/search/course/', [FrontController::class, 'search'])->name('front.search');
Route::get('/notifications/read/{notificationId}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/notifications', [NotificationController::class, 'showNotifications'])->name('notifications.index');



// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teacher-specific routes
    Route::middleware(ProvideRejectionReason::class)->group(function () {
        Route::get('/teachers/approval-notice', function () {
            return view('teachers.approval-notice');
        })->name('teachers.approval-notice');
    });

    Route::get('/reapply-teacher', [FrontController::class, 'reapplyForm'])->name('teacher.reapply');
    Route::post('/reapply-teacher', [FrontController::class, 'submitReapply'])->name('teacher.reapply.submit');


    // Checkout routes
    Route::get('/checkout/{packageId}', [FrontController::class, 'checkout'])->name('front.checkout')
        ->middleware('role:student');

    Route::post('/checkout/store', [FrontController::class, 'checkout_store'])->name('front.checkout.store')
        ->middleware('role:student');

    // Learning system
    Route::get('/learning/{course}/{courseVideoId}', [FrontController::class, 'learning'])->name('front.learning')
        ->middleware('role:student|teacher|owner');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class)
            ->middleware('role:owner');

        Route::resource('teachers', TeacherController::class)
            ->middleware('role:owner');

        // Penarikan saldo
        Route::get('/withdraw', [WithdrawController::class, 'index'])->name('withdraw.index')
            ->middleware('role:teacher|owner'); // Hanya untuk teacher atau owner

        Route::get('/withdraw/manage', [WithdrawController::class, 'manage'])->name('withdraw.manage')
            ->middleware('role:owner');

        Route::post('/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store')
            ->middleware('role:teacher'); // Hanya untuk teacher yang mengajukan

        Route::get('/withdraw/approval', [WithdrawController::class, 'approvalList'])->name('withdraw.approval')
            ->middleware('role:owner'); // Hanya untuk owner yang melihat daftar pending

        Route::put('/withdraw/{id}/approve', [WithdrawController::class, 'approve'])->name('withdraw.approve')
            ->middleware('role:owner'); // Owner menyetujui penarikan

        Route::put('/withdraw/{id}/reject', [WithdrawController::class, 'reject'])->name('withdraw.reject')
            ->middleware('role:owner'); // Owner menolak penarikan

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

        Route::resource('users', UserController::class)
            ->middleware('role:owner');
        Route::resource('guideline', GuidelineController::class)
            ->middleware('role:teacher');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/progress', [FrontController::class, 'progress'])->name('front.progress');
});

// Authentication routes
require __DIR__ . '/auth.php';
