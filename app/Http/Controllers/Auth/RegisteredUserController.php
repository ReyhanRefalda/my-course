<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher; // Import model Teacher
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', 'in:student,teacher'],
        ]);

        // Handle avatar upload
        $avatarPath = $request->hasFile('avatar')
            ? $request->file('avatar')->store('avatar', 'public')
            : 'images/avatar-default.png';

        // Create user
        $user = User::create([
            'name' => $request->name,
            'occupation' => $request->occupation,
            'balance' => 0,
            'avatar' => $avatarPath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => true, // Semua akun langsung aktif
        ]);

        // Tambahkan role sesuai account_type
        $role = Role::firstOrCreate(['name' => $request->account_type]);
        $user->assignRole($role);

        // Jika akun adalah teacher, tambahkan ke tabel teachers
        if ($request->account_type === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'status' => 'pending', // Teacher perlu persetujuan untuk aktif
            ]);
        }

        // Trigger event
        event(new Registered($user));

        // Login dan redirect sesuai account_type
        Auth::login($user);

        if ($request->account_type === 'teacher') {
            return redirect()->route('teachers.approval-notice')
                ->with('info', 'Your Teacher Account has been created. Waiting for admin approval.');
        }

        return redirect()->route('front.index')
            ->with('success', 'Student account has been successfully created!');
    }
}
