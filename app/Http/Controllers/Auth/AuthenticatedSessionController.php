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
    
        // Periksa peran pengguna setelah login
        if (Auth::check()) {
            $userRole = Auth::user()->role; // Sesuaikan dengan nama atribut role Anda di database
            
            if ($userRole === 'teacher' || $userRole === 'owner') {
                // Arahkan teacher dan owner ke dashboard
                return redirect()->route('dashboard');
            }
            
            // Arahkan student atau user biasa ke landing page
            return redirect()->route('front.index');
        }
    
        // Default fallback jika tidak ada role atau kondisi tidak terpenuhi
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
