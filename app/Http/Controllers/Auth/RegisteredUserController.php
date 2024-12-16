<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', 'in:student,teacher'],
        ]);

        if($request->hasFile('avatar')){
            $avatarPath = $request->file('avatar')->store('avatar', 'public');
        } else {
            $avatarPath = 'images/avatar-default.png';
        }

        $user = User::create([
            'name' => $request->name,
            'occupation' => $request->occupation,
            'balance' => 0,
            'avatar' => $avatarPath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => true, // Semua akun langsung aktif
            'status' => $request->account_type === 'teacher' ? 'pending' : 'approved', // Default status
        ]);

        // Tambahkan role sesuai account_type
        $role = Role::firstOrCreate(['name' => $request->account_type]);
        $user->assignRole($role);
        
        event(new Registered($user));

        if ($request->account_type === 'teacher') {
            Auth::login($user);
            return redirect()->route('teachers.approval-notice')
                ->with('info', 'Akun Teacher Anda telah dibuat. Menunggu persetujuan admin.');
        }

        // Login otomatis untuk student
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Akun Student berhasil dibuat!');
    }
}
