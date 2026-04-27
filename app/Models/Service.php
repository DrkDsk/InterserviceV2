<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service_caategory_id', 'name', 'price', 'requires_diagnosis', 'requires_visit'];
}
