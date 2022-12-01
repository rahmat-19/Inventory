<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['category', 'penanggung_jawabs', 'device_categories'];
    protected $casts = [
	'serialNumber' => 'array'
    ];
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['bulan'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->whereMonth('tanggalMasuk', $search);
            });
        });
        $query->when($filters['tahun'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->whereYear('tanggalMasuk', $search);
            });
        });
        $query->when($filters['tanggal'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->whereDate('tanggalMasuk', $search);
            });
        });

	$query->when($filters['status'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('satusBarang', $search);
            });
        });

	$query->when($filters['jenis'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('device_id', $search);
            });
        });

	$query->when($filters['hidden'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->whereNotIn('unit', [0]);
            });
        });

	$query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->with(['device_categories', 'penanggung_jawabs'])
                    ->whereRelation('device_categories', 'name', 'like', '%' . $search . '%')
                    ->orWhereRelation('penanggung_jawabs', 'name', 'like', '%' . $search . '%')
                    ->orWhere('device', 'like', '%' . $search . '%')
                    ->orWhere('serialNumber', 'like', '%' . $search . '%')
                    ->orWhere('unit', 'like', '%' . $search . '%')
                    ->orWhere('merek', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('pemilik', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        });
    }




    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function device_categories()
    {
        return $this->belongsTo(DeviceCategory::class, 'device_id', 'id');
    }
    public function penanggung_jawabs()
    {
        return $this->belongsTo(PenanggungJawab::class, 'penangungJawab_id', 'id');
    }
}
