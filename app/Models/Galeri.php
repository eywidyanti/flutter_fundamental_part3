<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;
    protected $table= 'galeri';
    protected $fillable = ['user_id','slug', 'gambar', 'gambar1', 'gambar2', 'video',  'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
