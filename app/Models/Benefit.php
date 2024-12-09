<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'packages_id'
    ];

    public function packages()
    {
        return $this->belongsTo(Package::class);
    }
}
