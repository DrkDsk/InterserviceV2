<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLogRepairRequest;
use App\Models\Repair;
use App\Models\RepairLog;
use Inertia\Inertia;

class RepairLogController extends Controller
{
    public function logs(Repair $repair)
    {
        $repair = $repair->load('logs');

        return Inertia::render('Repair/RepairLogs', [
            'repair' => $repair,
        ]);
    }

    public function update(RepairLog $repairLog, UpdateLogRepairRequest $request)
    {
        $repairLog->update($request->validated());

        return redirect()->back();
    }
}
