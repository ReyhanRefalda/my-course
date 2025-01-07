<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path_video',
        'course_id',
        'deleted_by',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    // Relasi untuk mendapatkan data user yang menghapus video
    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    
}
