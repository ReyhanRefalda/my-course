<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\DB;
use App\Models\SubscribeTransaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek jika user memiliki role 'teacher' dan status is_active = false
        if ($user->hasRole('teacher')) {
            $teacher = $user->teachers()
            ->orderBy('created_at', 'desc') // Ambil yang paling baru
            ->first();
            if (!$teacher || $teacher->status === 'pending' || $teacher->status === 'rejected') {
                return redirect()->route('teachers.approval-notice')
                    ->with('warning', 'Akun Anda belum disetujui oleh admin.');
            }
        }

        $totalViewersPerMonth = []; // Default jika user bukan teacher

        if ($user->hasRole('teacher')) {
            $teacher = $user->teachers()->first();
            $currentYear = now()->year;

            for ($month = 1; $month <= 6; $month++) {
                $viewersCount = $teacher->courses()
                    ->join('course_students', 'courses.id', '=', 'course_students.course_id')
                    ->whereMonth('course_students.created_at', $month)
                    ->whereYear('course_students.created_at', $currentYear)
                    ->count();

                $totalViewersPerMonth[] = [
                    'month' => date('F', mktime(0, 0, 0, $month, 1)),
                    'viewers' => $viewersCount,
                ];
            }
        }

        // chart transaction start
        $transactionsPerMonth = SubscribeTransaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $transactionData = [];
        for ($i = 1; $i <= 12; $i++) {
            $transactionData[] = $transactionsPerMonth[$i] ?? 0;
        }
        // chart transaction end

        // chart balance start
        $balancePerMonth = [];
        $totalBalance = 0;

        for ($month = 1; $month <= 12; $month++) {
            $monthlyTransactions = SubscribeTransaction::whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->get();

            $monthlyBalanceOwner = 0;
            $monthlyBalanceTeacher = 0;

            foreach ($monthlyTransactions as $transaction) {
                $totalAmount = $transaction->total_amount;

                $owners = User::role('owner')->get();
                $teachers = User::role('teacher')->get();

                $totalOwner = $owners->count();
                $totalTeacher = $teachers->count();

                $benefitOwner = $totalAmount * 0.5;
                $benefitTeacherTotal = $totalAmount * 0.5;
                $teacherPerShare = $totalTeacher > 0 ? $benefitTeacherTotal / 50 : 0;
                $distributedBenefitTeacher = $teacherPerShare * $totalTeacher;
                $remainingMoney = $benefitTeacherTotal - $distributedBenefitTeacher;

                $benefitOwner += $remainingMoney;

                // Hitung balance owner per bulan
                $monthlyBalanceOwner += $benefitOwner;

                // Hitung balance teacher per bulan
                $monthlyBalanceTeacher += $distributedBenefitTeacher;
            }

            $balancePerMonth[] = [
                'owner' => $monthlyBalanceOwner,
                'teacher' => $monthlyBalanceTeacher,
            ];

            $totalBalance += $monthlyBalanceOwner + $monthlyBalanceTeacher;
        }
        // chart balance end

        // Top Performers Teacher
        $topPerformingTeachers = Teacher::with(['courses.students'])
        ->where('status', 'approved') // Hanya ambil teacher yang disetujui
        ->get()
        ->map(function ($teacher) {
            $totalCourses = $teacher->courses->count();
            $totalViewers = $teacher->courses->sum(function ($course) {
                return $course->students->count();
            });
    
            return [
                'teacher_name' => $teacher->user->name,
                'total_courses' => $totalCourses,
                'total_viewers' => $totalViewers,
                'teacher_email' => $teacher->user->email,
                'teacher_avatar' => $teacher->user->avatar,
            ];
        })
        ->sortByDesc('total_viewers')
        ->take(5);
    

        // other data for owner
        $courses = Course::count();
        $categories = Category::count();
        $transactions = SubscribeTransaction::count();
        $students = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'teacher');
        })->count();
        $teachers = Teacher::count();
        $balanceOwner = User::whereHas('roles', function ($q) {
            $q->where('name', 'owner');
        })->first()->balance;
        $latestTransactions = SubscribeTransaction::with('package')->orderBy('created_at', 'desc')->limit(5)->get();

        // other data for teacher
        $balance = $user->balance;
        $totalCourses = $totalViewers = $totalStudents = null;
        if ($user->hasRole('teacher')) {
            $teacher = $user->teachers()->first();

            $totalCourses = $teacher->courses->count();
            $totalViewers = $teacher->courses->sum(function ($course) {
                return $course->students->count();
            });
            $totalStudents = $teacher->courses->map(function ($course) {
                return $course->students;
            })->flatten()->unique('id')->count();
        }

        return view('admin.dashboard', compact(
            'categories',
            'courses',
            'transactions',
            'students',
            'teachers',
            'balanceOwner',
            'transactionData',
            'balancePerMonth',
            'totalBalance',
            'latestTransactions',
            'topPerformingTeachers',
            'balance',
            'totalCourses',
            'totalViewers',
            'totalStudents',
            'totalViewersPerMonth'
        ));
    }
}
