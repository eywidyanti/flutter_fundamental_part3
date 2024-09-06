<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table= 'booking';
    protected $fillable = ['user_id', 'slug', 'nama', 'alamat', 'email','noHp', 'tanggal_mulai_penggunaan', 'nama_pengantin', 'jam_mulai_penggunaan', 'jam_berakhir_penggunaan', 'keterangan', 'total', 'status', 'expired'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
