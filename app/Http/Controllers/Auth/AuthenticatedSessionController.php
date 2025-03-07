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
    
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('front.index');
        }
    
        $user = Auth::user(); // Dapatkan data pengguna
    
        // Cari data teacher terkait pengguna
        $teacher = \App\Models\Teacher::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
    
        // Jika user pernah mendaftar sebagai teacher dan statusnya pending atau rejected, arahkan ke approval notice
        if ($teacher && in_array($teacher->status, ['pending', 'rejected'])) {
            return redirect()->route('teachers.approval-notice');
        }
    
        // Jika user memiliki role "teacher" atau "owner", arahkan ke dashboard
        if ($user->hasRole(['teacher', 'owner'])) {
            return redirect()->route('dashboard');
        }
    
        // Jika role tetap student atau lainnya, arahkan ke landing page
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
