<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'occupation',
        'balance',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students');
    }

    public function subscribe_transactions()
    {
        return $this->hasMany(SubscribeTransaction::class);
    }

    public function hasActiveSubscription()
    {
        $latestSubscription = $this->subscribe_transactions()
            ->where('status', '=', 'approved')
            ->where('expired_at', '>=', Carbon::now())
            ->latest('expired_at')
            ->first();

        return $latestSubscription !== null;
    }

    public function getActiveSubscription()
    {
        return $this->subscribe_transactions()
            ->where('status', '=', 'approved')
            ->where('expired_at', '>=', now())
            ->latest('expired_at')
            ->first();
    }


    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function isTeacherActive()
    {
        if ($this->hasRole('teacher')) {
            $teacher = $this->teachers()->first(); // Ambil data dari relasi
            return $teacher && $teacher->is_active;
        }
        return false;
    }
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    // public function isTeacherReapplicationAllowed()
    // {
    //     return $this->status === 'rejected';
    // }

    public function watchedVideos()
    {
        return $this->hasMany(VideoHistories::class, 'user_id');
    }

    public function courseStatus($courseId)
    {
        // Total video dalam kursus
        $totalVideos = CourseVideo::where('course_id', $courseId)->count();

        // Total video yang sudah ditonton user berdasarkan video_histories
        $watchedVideos = $this->watchedVideos()
            ->where('course_id', $courseId) // Filter berdasarkan course_id
            ->distinct('video_id') // Pastikan hanya menghitung video unik
            ->count('video_id'); // Hitung jumlah video yang sudah ditonton

        // Jika kursus tidak memiliki video, kembalikan "No Videos"
        if ($totalVideos === 0) {
            return 'No Videos';
        }

        // Jika user belum menonton video sama sekali, jangan tampilkan badge
        if ($watchedVideos === 0) {
            return 'Not Watched';
        }

        return $watchedVideos >= $totalVideos ? 'Done' : 'Progress';
    }

    public function articles() {
        return $this->belongsToMany(Artikel::class, 'article_histories', 'user_id', 'article_id');
    }
}
