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
        $teachers = Teacher::orderBy('id', 'desc')->get();

        return view('admin.teachers.index', [
            'teachers' => $teachers
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
    public function store(StoreTeacherRequest $request)
    {
        $validated = $request->validated();
    
        // Mencari user berdasarkan email
        $user = User::where('email', $validated['email'])->first();
    
        // Jika user tidak ditemukan, kembalikan error
        if (!$user) {
            return back()->withErrors([
                'email' => 'Data tidak ditemukan'
            ]);
        }
    
        // Jika user sudah memiliki role 'teacher', kembalikan error
        if ($user->hasRole('teacher')) {
            return back()->withErrors([
                'email' => 'Email tersebut sudah menjadi Guru'
            ]);
        }
    
        // Transaksi untuk memastikan konsistensi data
        DB::transaction(function () use ($validated, $user) {
            $validated['user_id'] = $user->id;
            $validated['is_active'] = true;
    
            // Buat data teacher baru
            $teacher = Teacher::create($validated);
    
            // Jika user sudah memiliki role 'student', hilangkan role tersebut
            if ($user->hasRole('student')) {
                $user->removeRole('student');
            }
    
            // Assign role 'teacher' tetapi dengan status belum terverifikasi
            $user->assignRole('teacher');
            $user->is_verified = false;  // User masih menunggu persetujuan admin
            $user->save();
        });
    
        // Redirect ke halaman pemberitahuan approval
        return redirect()->route('teachers.approval.notice')
                         ->with('warning', 'Akun Teacher Anda sedang menunggu persetujuan admin.');
    }
    

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
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();

            $user = User::find($teacher->user_id);
            $user->removeRole('teacher');
            $user->assignRole('student');

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
            throw $error;
        }
    }
}
