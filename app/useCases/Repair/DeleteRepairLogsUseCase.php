<?php

namespace App\useCases\Repair;

use App\Models\Repair;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class DeleteRepairLogsUseCase
{
    /**
     * @throws Throwable
     */
    public function execute(Repair $repair): void
    {
        DB::transaction(static function () use ($repair) {
            $repair->logs()->delete();
        });
    }
}
