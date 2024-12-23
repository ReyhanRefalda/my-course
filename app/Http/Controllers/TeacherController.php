<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTeacherRequest;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hanya menampilkan teachers yang status = 'pending'
        $teachers = Teacher::all();

        return view('admin.teachers.index', [
            'teachers' => $teachers,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $teacherId) {}

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $teacher)
    {
        // Validasi ID yang diterima
        $teacher = Teacher::find($teacher);

        if (!$teacher) {
            return back()->withErrors(['teacher' => 'Guru tidak ditemukan.']);
        }

        // Update status teacher menjadi 'approved' (bisa juga disesuaikan dengan status lain)
        $teacher->status = 'approved';
        $teacher->save();

        // Dapatkan user terkait dengan teacher
        $user = $teacher->user;

        // Periksa apakah user sudah memiliki role 'teacher', jika belum beri role tersebut
        if (!$user->hasRole('teacher')) {
            $user->assignRole('teacher');
        }

        // Tandai user sebagai verified karena telah disetujui
        $user->is_verified = true;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.teachers.index')
            ->with('success', 'Account Teacher approved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // TeacherController.php
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();

            // Menghapus role 'teacher' dan menggantinya menjadi 'student'
            $user = User::find($teacher->user_id);
            $user->removeRole('teacher');
            $user->assignRole('student');

            return redirect()->route('admin.teachers.index')->with('success', 'Account teacher deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
            throw $error;
        }
    }
}
