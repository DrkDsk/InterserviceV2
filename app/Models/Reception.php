<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    protected $fillable = ['folio', 'client_id', 'customer_name', 'customer_phone', 'status', 'received_at', 'delivered_at', 'created_by', 'notes'];
}
