<?php

namespace App\useCases\Repair;

use App\Models\Device;
use App\Models\Reception;
use App\Models\Repair;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class DeleteRepairUseCase
{
    /**
     * @throws Throwable
     */
    public function execute(Repair $repair): void
    {
        DB::transaction(function () use ($repair) {
            $repair->loadMissing('device', 'reception');

            $device = $repair->device;
            $reception = $repair->reception;

            $repair->delete();

            $this->deleteDeviceIfUnused($device);
            $this->deleteReceptionIfUnused($reception);
        });
    }

    private function deleteDeviceIfUnused(?Device $device): void
    {
        if (!$device) {
            return;
        }

        $isDeviceUsed = Repair::query()
            ->where('device_id', $device->id)
            ->exists();

        if (!$isDeviceUsed) {
            $device->delete();
        }
    }

    private function deleteReceptionIfUnused(?Reception $reception): void
    {
        if (!$reception) {
            return;
        }

        $hasRepairs = Repair::query()
            ->where('reception_id', $reception->id)
            ->exists();

        $hasDevices = Device::query()
            ->where('reception_id', $reception->id)
            ->exists();

        if (!$hasRepairs && !$hasDevices) {
            $reception->delete();
        }
    }
}
