<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscribeTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'total_amount',
        'is_paid',
        'user_id',
        'proof',
        'subscription_start_date',
        'expired_at',
        'package_id',
    ];

    protected $casts = [
        'subscription_start_date' => 'datetime',
        'expired_at' => 'datetime',
    ];    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
