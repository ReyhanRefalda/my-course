<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course_histories extends Model
{
    protected $table = 'course_histories';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Relasi ke tabel User (jika ada)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
