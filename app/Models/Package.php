<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'harga',
        'tipe'
    ];

    public function benefits()
    {
        return $this->hasMany(Benefit::class, 'packages_id');
    }
}
