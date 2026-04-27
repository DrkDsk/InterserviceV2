<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'reception_id',
        'device_id',
        'technician_id',
        'service_id',
        'status',
        'diagnosis',
        'solution',
        'cost',
        'repaired_date',
    ];
}
