<?php

namespace App\Enums;

enum RepairEnum: string
{
    case Pending = 'pending';
    case Diagnosing = 'diagnosing';
    case WaitingParts = 'waiting_parts';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
