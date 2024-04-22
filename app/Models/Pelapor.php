<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'pelapor';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
