<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenanggungJawab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function barang_keluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
    public function barang_masuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }
    public function history_barang_masuks()
    {
        return $this->hasMany(HistoryBarangMasuk::class);
    }
}
