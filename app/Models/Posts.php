<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'tanggaldibuat',
        'cover',
        'album_id',
        'user_id',
    ];
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'post_id');
    }
}
