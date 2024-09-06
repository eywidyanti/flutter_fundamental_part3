<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketDekor extends Model
{
    use HasFactory;
    protected $table= 'paket_dekor';

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function dekor()
    {
        return $this->belongsTo(Dekor::class);
    }
}
