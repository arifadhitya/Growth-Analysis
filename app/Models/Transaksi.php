<?php

namespace App\Models;

use App\Models\Analisis;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kodetransaksi',
        'totalbayar',
        'operator',
        'tanggaljual',
    ];

    public function pembelian(){
        //return $this->belongsTo(Pembelian::class);
        return $this->hasMany(Pembelian::class);
    }

    public function analisis(){
        //return $this->belongsTo(Pembelian::class);
        return $this->hasMany(Analisis::class);
    }
}