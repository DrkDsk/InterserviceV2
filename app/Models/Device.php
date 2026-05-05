<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    protected $fillable = [
        'device_category_id',
        'reception_id',
        'brand',
        'model',
        'serial_number',
        'inventory_number',
        'password',
        'issue',
        'observations',
        'accessories',
    ];

    public function deviceCategory(): BelongsTo
    {
        return $this->belongsTo(DeviceCategory::class);
    }
}
