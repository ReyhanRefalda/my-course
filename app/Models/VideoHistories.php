<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoHistories extends Model
{
    //
    protected $fillable = ['user_id', 'course_id', 'video_id', 'watched_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function video()
    {
        return $this->belongsTo(CourseVideo::class);
    }
}
