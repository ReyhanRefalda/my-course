<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvideRejectionReason
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // Ambil pengguna yang sedang login
        $teacher = \App\Models\Teacher::where('user_id', $user->id)
        ->orderBy('created_at', 'desc') // Ambil yang paling baru
        ->first();

        // Jika user adalah teacher dengan status "rejected"
        if ($teacher && $teacher->status === 'rejected') {
            view()->share('rejection_reason', $teacher->rejection_reason);
        }

        return $next($request);
    }
}

