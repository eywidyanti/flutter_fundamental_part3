<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table= 'paket';
    protected $fillable = ['user_id','dekor_id','nama', 'gambar', 'slug', 'deskripsi', 'harga'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dekor()
    {
        return $this->belongsTo(Dekor::class)->using(PaketDekor::class);
    }

    public function paketDekors()
    {
        return $this->hasMany(PaketDekor::class);
    }
    public function bookingDetail()
    {
        return $this->hasMany(BookingDetail::class);
    }


}
