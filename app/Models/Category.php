<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function activity_logs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    public function barang_masuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }
    public function history_barang_masuks()
    {
        return $this->hasMany(HistoryBarangMasuk::class);
    }
    public function penanggung_jawabs()
    {
        return $this->hasMany(PenanggungJawab::class);
    }



    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
