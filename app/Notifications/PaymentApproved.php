<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Ramsey\Uuid\Guid\Guid;  // Menambahkan penggunaan UUID

class PaymentApproved extends Notification
{
    use Queueable;

    protected $transaction;

    // Konstruktor untuk menerima transaksi yang akan dikirimkan
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    // Menggunakan saluran database untuk mengirimkan notifikasi
    public function via($notifiable)
    {
        return ['database'];  // Menggunakan database untuk menyimpan notifikasi
    }

    // Menyimpan notifikasi di database
    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'message' => 'Your payment for the package ' . $this->transaction->package->name . ' has been approved by the owner.',
            'status' => 'approved',
            // Menambahkan ID UUID secara manual jika menggunakan UUID
            'id' => (string) Guid::uuid4() // Menghasilkan UUID baru untuk ID notifikasi
        ];
    }
}
