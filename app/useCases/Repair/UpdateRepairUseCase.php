<?php

namespace App\useCases\Repair;

use App\Enums\RepairStatus;
use App\Http\Requests\UpdateRepairRequest;
use App\Models\Repair;

readonly  class UpdateRepairUseCase
{
    public function execute(Repair $repair, UpdateRepairRequest $request): void
    {
        $validated = $request->validated();

        $repairCompleted = (
            $validated["status"] === RepairStatus::Completed->value &&
            $repair->status !== RepairStatus::Completed->value
        );

        $solution = $validated['solution'];

        if (!$repairCompleted) {
            $validated['solution'] = null;
        }

        $repair->update($validated);

        if (filled($solution)) {
            $data = [
                'created_by' => auth()->id(),
                'message' => $solution
            ];

            $repair->logs()->create($data);
        }
    }

}
