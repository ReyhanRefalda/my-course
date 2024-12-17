<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\SubscribeTransaction;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek jika user memiliki role 'teacher' dan status is_active = false
        if ($user->hasRole('teacher')) {
            $teacher = $user->teacher; // Relasi ke tabel teacher
            if (!$teacher || $teacher->status === 'pending' || $teacher->status === 'rejected') {
                // Redirect ke halaman persetujuan jika teacher masih dalam status pending
                return redirect()->route('teachers.approval-notice')
                    ->with('warning', 'Akun Anda belum disetujui oleh admin.');
            }
        }


        // Query kursus berdasarkan role
        $courseQuery = Course::query();

        if ($user->hasRole('teacher')) {
            $courseQuery->whereHas('teacher', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

            $students = CourseStudent::whereIn('course_id', $courseQuery->select('id'))
                ->distinct('user_id')
                ->count('user_id');
        } else {
            $students = CourseStudent::distinct('user_id')->count('user_id');
        }

        $courses = $courseQuery->count();
        $categories = Category::count();
        $transactions = SubscribeTransaction::count();
        $teachers = Teacher::count();

        return view('admin.dashboard', compact('categories', 'courses', 'transactions', 'students', 'teachers'));
    }
}
