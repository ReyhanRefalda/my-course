<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends DatabaseNotification
{
    use HasFactory;

    // Menetapkan bahwa kolom id bukan auto-incrementing integer
    public $incrementing = false;
    
    // Menetapkan bahwa tipe id adalah UUID
    protected $keyType = 'string';
}
