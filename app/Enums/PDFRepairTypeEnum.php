<?php

namespace App\Enums;

enum PDFRepairTypeEnum: string
{
    case DELIVERY = 'delivery';

    case PICKUP = 'pickup';

    case RECEPTION = 'reception';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
