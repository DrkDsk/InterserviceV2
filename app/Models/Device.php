<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
