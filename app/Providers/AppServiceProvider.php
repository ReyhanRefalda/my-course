<?php

namespace App\Providers;

use App\Models\Artikel;
use App\Policies\ArtikelPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Artikel::class, ArtikelPolicy::class);

        View::composer(['components.nav', 'components.navcat'], function ($view) {
            $user = Auth::user();
            $remainingDays = null;

            if ($user) {
                $subscription = $user->getActiveSubscription();

                if ($subscription) {
                    // Hitung sisa hari dan bulatkan ke bawah
                    $remainingDays = floor(now()->diffInDays($subscription->expired_at, false));
                }
            }

            $view->with('remainingDays', $remainingDays);
        });
    }
}
