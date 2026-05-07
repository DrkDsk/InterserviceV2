<?php

namespace App\Enums;

enum ServiceCategoryType: string
{
    case Local = 'local';
    case FieldService = 'field_service';
    case Remote = 'remote';

    static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
