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
        public string  $device_name,
        public string  $technician_name,
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
        $deviceName = "{$repair->device->brand}" . " - " . "{$repair->device->model}";

        return new self(
            id: $repair->id,
            reception_id: $repair->reception->id,
            device_name: $deviceName,
            technician_name: $repair->technician->name,
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
