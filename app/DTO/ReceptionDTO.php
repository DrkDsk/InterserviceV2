<?php

namespace App\DTO;

use App\Enums\ReceptionStatus;
use App\Models\Reception;
use Carbon\Carbon;

class ReceptionDTO
{
    public function __construct(
        public string          $folio,
        public ?string         $customer_name,
        public ?string         $customer_phone,
        public ReceptionStatus $status,
        public ?Carbon         $received_at,
        public ?Carbon         $delivered_at,
        public int             $created_by,
        public ?string         $notes,
    )
    {
    }

    public static function fromReception(Reception $reception): self
    {
        $receivedAt = $reception->received_at;
        $deliveredAt = $reception->delivered_at;

        return new self(
            folio: $reception->folio,
            customer_name: $reception->client?->name ?? $reception->customer_name,
            customer_phone: $reception->client?->phone ?? $reception->customer_phone,
            status: ReceptionStatus::from($reception->status),
            received_at: $receivedAt ? Carbon::parse($receivedAt) : null,
            delivered_at: $deliveredAt ? Carbon::parse($deliveredAt) : null,
            created_by: $reception->created_by,
            notes: $reception->notes
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
