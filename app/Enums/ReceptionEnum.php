<?php

namespace App\Enums;

enum ReceptionEnum: string
{
    case Received = 'received';
    case Repairing = 'repairing';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
