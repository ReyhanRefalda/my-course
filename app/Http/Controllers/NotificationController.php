<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();  // Menandai notifikasi sebagai dibaca
        }

        return redirect()->route('notifications.index');  // Redirect ke halaman notifikasi
    }

    public function showNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications;  // Ambil semua notifikasi

        return view('notifications.index', compact('notifications'));
    }

    // public function showNav()
    // {
    //     $user = Auth::user();
    //     $unreadNotifications = $user->unreadNotifications; // Notifikasi yang belum dibaca
    //     $notificationCount = $unreadNotifications->count(); // Jumlah notifikasi yang belum dibaca

    //     // Mengirimkan data ke view 'components.nav'
    //     return view('components.nav', compact('unreadNotifications', 'notificationCount'));
    // }
}
