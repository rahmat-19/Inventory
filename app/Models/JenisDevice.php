<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDevice extends Model
{
    use HasFactory;

    public function device_categories()
    {
        return $this->hasMany(DeviceCategory::class);
    }
}
