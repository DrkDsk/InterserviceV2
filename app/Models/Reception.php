<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reception extends Model
{
    protected $fillable = [
        'folio',
        'client_id',
        'customer_name',
        'customer_phone',
        'status',
        'received_at',
        'delivered_at',
        'created_by',
        'notes'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
