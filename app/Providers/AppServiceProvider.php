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
   // AppServiceProvider.php
public function boot(): void
{
    // Menambahkan data ke view 'components.nav' dan 'components.navcat'
    View::composer(['components.nav', 'components.navcat'], function ($view) {
        $user = Auth::user();
        $remainingDays = null;
        $notificationCount = 0;
        $unreadNotifications = collect();

        if ($user) {
            // Mengambil langganan aktif dan menghitung sisa hari langganan
            $subscription = $user->getActiveSubscription();
            if ($subscription) {
                $remainingDays = floor(now()->diffInDays($subscription->expired_at, false));
            }

            // Mengambil notifikasi yang belum dibaca
            $unreadNotifications = $user->unreadNotifications;
            $notificationCount = $unreadNotifications->count(); // Menghitung jumlah notifikasi yang belum dibaca
        }

        // Mengirim data ke view
        $view->with([
            'remainingDays' => $remainingDays,
            'notificationCount' => $notificationCount,
            'unreadNotifications' => $unreadNotifications
        ]);
    });
}

}
