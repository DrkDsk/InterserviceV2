<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLogRepairRequest;
use App\Models\Repair;
use App\Models\RepairLog;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RepairLogController extends Controller
{
    public function logs(Repair $repair): Response
    {
        $repair->load([
            'logs' => fn($q) => $q->oldest(),
        ])->loadCount('logs');

        return Inertia::render('Repair/RepairLogs', [
            'repair' => $repair,
        ]);
    }

    public function store(Repair $repair, UpdateLogRepairRequest $request): RedirectResponse
    {
        $validated = array_merge($request->validated(), [
            'created_by' => auth()->id(),
        ]);

        $repair->logs()->create($validated);

        return redirect()->back()->with('success', 'Reparación creada');
    }

    public function update(RepairLog $repairLog, UpdateLogRepairRequest $request): RedirectResponse
    {
        $repairLog->update($request->validated());

        return redirect()->back()->with('info', 'Reparación actualizada');
    }

    public function destroy(RepairLog $repairLog): RedirectResponse
    {
        $repairLog->delete();

        return redirect()->back()->with('error', 'Reparación eliminada');
    }
}
