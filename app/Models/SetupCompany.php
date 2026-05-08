<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupCompany extends Model
{
    protected $table = 'setup_company';
    
    public $fillable = [
        'facebook',
        'email',
        'WhatsApp',
        'phone',
        'location',
        'city',
    ];
}
