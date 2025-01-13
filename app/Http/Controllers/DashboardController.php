<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
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

        // Query transaksi berdasarkan bulan
        $transactionsPerMonth = SubscribeTransaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Format data untuk setiap bulan (Jan - Des)
        $transactionData = [];
        for ($i = 1; $i <= 12; $i++) {
            $transactionData[] = $transactionsPerMonth[$i] ?? 0; // Isi 0 jika tidak ada transaksi
        }

        // Data lainnya
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

        return view('admin.dashboard', compact('categories', 'courses', 'transactions', 'students', 'teachers', 'transactionData', 'balanceOwner'));
    }
}
