<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analisis extends Model
{
    use HasFactory;

    protected $fillable = [
        'kodetransaksi',
        'totalbayar',
        'tanggaltransaksi',
        'kodeproduk',
        'jumlahproduk',
    ];

    public function setTanggal($value){
        $this->attributes['tanggaltransaksi'] = Carbon::createFromFormat('dd/mm/yyyy', $value)->format('Y-m-d');
    }

    public function getTanggal($value){
        return Carbon::createFromFormat('Y-m-d', $this->attributes['tanggaltransaksi'])->format('dd/mm/yyyy') ;
    }

    public function produk(){
        //return $this->hasMany(Produk::class);
        return $this->belongsTo(Produk::class, 'kodetransaksi');
    }

    public function transaksi(){
        //return $this->hasMany(Transaksi::class);
        return $this->belongsTo(Transaksi::class, 'kodeproduk');
    }

}
