<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table= 'booking_detaill';
    protected $fillable = ['user_id','dekor_id', 'paket_id' ,'booking_id', 'slug', 'quantity', 'harga'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dekor()
    {
        return $this->belongsTo(Dekor::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
