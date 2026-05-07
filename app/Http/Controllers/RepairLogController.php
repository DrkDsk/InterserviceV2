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
        $repair->load([
            'logs' => fn($q) => $q->oldest()
        ]);

        return Inertia::render('Repair/RepairLogs', [
            'repair' => $repair,
        ]);
    }

    public function store(Repair $repair, UpdateLogRepairRequest $request)
    {
        $validated = array_merge($request->validated(), [
            'created_by' => auth()->id(),
        ]);

        $repair->logs()->create($validated);

        return redirect()->back()->with('success', 'Reparación actualizada');
    }

    public function update(RepairLog $repairLog, UpdateLogRepairRequest $request)
    {
        $repairLog->update($request->validated());

        return redirect()->back()->with('info', 'Reparación actualizada');
    }

    public function destroy(RepairLog $repairLog)
    {
        $repairLog->delete();

        return redirect()->back()->with('error', 'Reparación eliminada');
    }
}
