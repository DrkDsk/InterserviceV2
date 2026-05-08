<?php

namespace App\Enums;

enum PDFRepairTypeEnum: string
{
    case DELIVERY = 'DELIVERY';

    case PICKUP = 'PICKUP';

    case RECEPTION = 'RECEPTION';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
