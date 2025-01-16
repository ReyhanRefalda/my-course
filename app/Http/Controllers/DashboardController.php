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
            $teacher = $user->teacher;
            if (!$teacher || $teacher->status === 'pending' || $teacher->status === 'rejected') {
                return redirect()->route('teachers.approval-notice')
                    ->with('warning', 'Akun Anda belum disetujui oleh admin.');
            }
        }

        // chart transaction
        $transactionsPerMonth = SubscribeTransaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $transactionData = [];
        for ($i = 1; $i <= 12; $i++) {
            $transactionData[] = $transactionsPerMonth[$i] ?? 0;
        }


        // chart balance
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

        // other data
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
        ));
    }
}
