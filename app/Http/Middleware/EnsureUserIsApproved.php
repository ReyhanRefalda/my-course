<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_approved) {
            return redirect()->route('teachers.approval.notice')
                ->with('info', 'Akun Anda menunggu persetujuan admin.');
        }

        return $next($request);
    }
}
