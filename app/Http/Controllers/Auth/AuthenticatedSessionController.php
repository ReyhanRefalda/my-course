<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            $user = Auth::user(); // Dapatkan data pengguna
            $userRole = $user->role; // Ambil atribut role dari pengguna

            // Cari data teacher terkait pengguna, jika ada
            $teacher = \App\Models\Teacher::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->first();

            // Jika data teacher ditemukan dan statusnya "rejected", arahkan ke approval-notice
            if ($teacher && $teacher->status === 'rejected') {
                return redirect()->route('teachers.approval-notice');
            }

            // Jika role adalah teacher atau owner, arahkan ke dashboard
            if (in_array($userRole, ['teacher', 'owner'])) {
                return redirect()->route('dashboard');
            }

            // Jika role adalah student atau lainnya, arahkan ke landing page
            return redirect()->route('front.index');
        }

        // Default fallback jika kondisi login tidak terpenuhi
        return redirect()->route('front.index');
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
