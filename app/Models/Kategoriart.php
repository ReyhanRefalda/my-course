<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategoriart extends Model
{
    use SoftDeletes;

    protected $table = 'kategoriart';
    protected $fillable = ['name', 'icon'];

    // public function artikels(): BelongsToMany
    // {
    //     return $this->belongsToMany(Artikel::class, 'artikel_kategoriart', 'kategoriart_id', 'artikel_id');
    // }
}
