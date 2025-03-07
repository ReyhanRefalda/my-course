<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
    
        // Ambil user yang memiliki role 'student' tetapi tidak memiliki role 'teacher'
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'teacher');
        });
    
        // Filter pencarian jika ada input di search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }
    
        // Filter untuk hanya menampilkan user yang memiliki subscription aktif
        if ($request->filled('subscription')) {
            $query->whereHas('subscribe_transactions', function ($q) {
                $q->where('status', 'approved')
                    ->where('expired_at', '>=', \Carbon\Carbon::now());
            });
        }
    
        // Ambil data user dengan relasi subscription
        $users = $query->with(['subscribe_transactions' => function ($q) {
            $q->where('status', 'approved')
                ->orderBy('expired_at', 'desc');
        }])
        ->paginate(5)
        ->appends($request->query());
    
        return view('admin.user.index', compact('users'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        $query = User::query();
    
        // Hanya ambil user dengan role 'student'
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'student');
        });
    
        // Filter untuk hanya menampilkan user yang memiliki subscription aktif
        if ($request->filled('subscription')) {
            $query->whereHas('subscribe_transactions', function ($q) {
                $q->where('status', 'approved') // Menggunakan 'status' menggantikan 'is_paid'
                    ->where('expired_at', '>=', \Carbon\Carbon::now());
            });
        }
    
        // Ambil data user dengan relasi subscription
        $users = $query->with(['subscribe_transactions' => function ($q) {
            $q->where('status', 'approved') // Perubahan dari 'is_paid' ke 'status'
                ->orderBy('expired_at', 'desc');
        }])->get();
    
        return view('admin.user.show', compact('user'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Admin/UserController.php
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // validasi file avatar
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars');
        }

        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->hasActiveSubscription()) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete user with active subscription.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
