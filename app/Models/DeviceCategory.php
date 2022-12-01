<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceCategory extends Model
{

    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['jenis_devices'];

    public function barang_masuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }
    public function history_barang_masuks()
    {
        return $this->hasMany(HistoryBarangMasuk::class);
    }
    public function barang_keluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    public function jenis_devices()
    {
        return $this->belongsTo(JenisDevice::class, 'jenis_id', 'id');
    }
}
