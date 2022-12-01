<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['category'];
    protected $casts = [
	'dataBaru' => 'array',
        'dataLama' => 'array'
    ];




    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
