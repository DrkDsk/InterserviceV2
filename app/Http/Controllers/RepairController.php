<?php

namespace App\Http\Controllers;

use App\actions\Repairs\FormatRepairsAction;
use App\Enums\RepairStatus;
use App\Http\Requests\ConfirmRepairDestructiveActionRequest;
use App\Http\Requests\CreateRepairRequest;
use App\Http\Requests\SearchClientRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Http\Resources\ErrorResource;
use App\Models\Repair;
use App\useCases\Client\FindClientUseCase;
use App\useCases\Client\GetClientsUseCase;
use App\useCases\DeviceCategory\GetDeviceCategoriesUseCase;
use App\useCases\Repair\DeleteRepairLogsUseCase;
use App\useCases\Repair\DeleteRepairUseCase;
use App\useCases\Repair\PaginateRepairsUseCase;
use App\useCases\Repair\StoreRepairUseCase;
use App\useCases\Repair\UpdateRepairUseCase;
use App\useCases\Service\GetServiceUseCase;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class RepairController extends Controller
{
    public function index(
        PaginateRepairsUseCase $paginateRepairsUseCase,
        FormatRepairsAction $formatRepairsAction): Response
    {
        $repairs = $paginateRepairsUseCase->execute(50)->toArray();

        $repairs['data'] = $formatRepairsAction->execute($repairs['data']);

        return Inertia::render('Repair/RepairIndex', [
            'repairs' => $repairs,
        ]);
    }

    public function create(
        SearchClientRequest $request,
        GetDeviceCategoriesUseCase $getDeviceCategoriesUseCase,
        GetClientsUseCase $getClientsUseCase,
        GetServiceUseCase $getServiceUseCase,
        FindClientUseCase $findClientUseCase,
    ): Response {
        $selectedClient = null;

        $formClientId = $request->input('client_id');

        if ($formClientId) {
            $selectedClient = $findClientUseCase->execute($formClientId);
        }

        $search = trim($request->input('search'));

        $deviceCategories = $getDeviceCategoriesUseCase->execute();
        $clients = $getClientsUseCase->execute($search);
        $services = $getServiceUseCase->execute();

        return Inertia::render('Repair/RepairCreate', [
            'deviceCategories' => $deviceCategories,
            'clients' => $clients,
            'selectedClient' => $selectedClient,
            'services' => $services,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(
        CreateRepairRequest $request,
        StoreRepairUseCase $storeRepairUseCase,
    ) {
        try {
            $validated = $request->validated();

            $storeRepairUseCase->execute($validated);

            return redirect()->route('repairs.index');
        } catch (Exception $exception) {
            return new ErrorResource($exception->getMessage());
        }
    }

    public function edit(Repair $repair): Response
    {
        $repair = $repair->load('reception.client', 'technician', 'device.deviceCategory', 'service')->loadCount('logs');

        $statuses = RepairStatus::options();

        return Inertia::render('Repair/RepairEdit', [
            'repair' => $repair,
            'statuses' => $statuses,
        ]);
    }

    public function update(Repair $repair, UpdateRepairRequest $request, UpdateRepairUseCase $updateRepairUseCase): RedirectResponse
    {
        $updateRepairUseCase->execute($repair, $request);

        return redirect()->back()->with('info', 'Reparación actualizada');
    }

    public function settings(Repair $repair): Response
    {
        $repair->load('reception.client', 'device', 'technician')->loadCount('logs');

        return Inertia::render('Repair/RepairSettings', [
            'repair' => $repair,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(
        Repair $repair,
        ConfirmRepairDestructiveActionRequest $request,
        DeleteRepairUseCase $deleteRepairUseCase,
    ): RedirectResponse {
        $request->validated();
        $deleteRepairUseCase->execute($repair);

        return redirect()
            ->route('repairs.index')
            ->with('success', 'La reparación y sus registros asociados fueron eliminados.');
    }

    /**
     * @throws Throwable
     */
    public function destroyLogs(
        Repair $repair,
        ConfirmRepairDestructiveActionRequest $request,
        DeleteRepairLogsUseCase $deleteRepairLogsUseCase,
    ): RedirectResponse {
        $request->validated();
        $deleteRepairLogsUseCase->execute($repair);

        return redirect()
            ->route('repairs.settings', $repair->id)
            ->with('success', 'Los logs de la reparación fueron eliminados.');
    }
}
