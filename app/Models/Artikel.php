<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'status',
        'tumbnail',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function kategoriarts(): BelongsToMany
    {
        return $this->belongsToMany(Kategoriart::class, 'artikel_kategoriart', 'artikel_id', 'kategoriart_id')
                    ->withTimestamps()
                    ->withTrashed(); // Tetap menampilkan kategori meskipun sudah dihapus
    }
}
