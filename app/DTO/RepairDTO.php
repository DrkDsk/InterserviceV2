<?php

namespace App\DTO;

use App\Models\Repair;
use Carbon\Carbon;
use DateTime;

class RepairDTO
{
    public function __construct(
        public int     $id,
        public int     $reception_id,
        public int     $device_id,
        public int     $technician_id,
        public ?int    $service_id,
        public string  $status,
        public ?string $issue,
        public ?string $observations,
        public ?string $solution,
        public ?string $cost,
        public ?Carbon $repaired_date,
    )
    {
    }

    public static function fromRepair(Repair $repair): self
    {
        $repairedAt = $repair->repaired_date;

        return new self(
            id: $repair->id,
            reception_id: $repair->reception->id,
            device_id: $repair->device_id,
            technician_id: $repair->technician_id,
            service_id: $repair->service_id,
            status: $repair->status,
            issue: $repair->issue,
            observations: $repair->observations,
            solution: $repair->solution,
            cost: $repair->cost,
            repaired_date: $repairedAt ? Carbon::parse($repairedAt) : null,
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
