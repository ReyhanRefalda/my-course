<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentRejected extends Notification
{
    use Queueable;

    protected $transaction;
    protected $reason; // Tambahkan properti reason

    /**
     * Create a new notification instance.
     */
    public function __construct($transaction, $reason)
    {
        $this->transaction = $transaction;
        $this->reason = $reason; // Simpan reason
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];  // Notifikasi disimpan di database
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'message' => 'Your payment for the package ' . $this->transaction->package->name . ' has been rejected.',
            'status' => 'rejected',
            'reason' => $this->reason, // Sekarang tidak error karena sudah didefinisikan
        ];
    }
}
