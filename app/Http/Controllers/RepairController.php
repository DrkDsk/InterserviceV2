<?php

namespace App\Http\Controllers;

use App\actions\Repairs\FormatRepairsAction;
use App\Enums\RepairEnum;
use App\Http\Requests\CreateRepairRequest;
use App\Http\Requests\SearchClientRequest;
use App\Http\Requests\UpdateLogRepairRequest;
use App\Http\Resources\ErrorResource;
use App\Models\Repair;
use App\Models\RepairLog;
use App\useCases\Client\FindClientUseCase;
use App\useCases\Client\GetClientsUseCase;
use App\useCases\DeviceCategory\GetDeviceCategoriesUseCase;
use App\useCases\Repair\PaginateRepairsUseCase;
use App\useCases\Repair\StoreRepairUseCase;
use App\useCases\Service\GetServiceUseCase;
use Exception;
use Inertia\Inertia;
use Throwable;

class RepairController extends Controller
{
    public function index(
        PaginateRepairsUseCase $paginateRepairsUseCase,
        FormatRepairsAction    $formatRepairsAction)
    {
        $repairs = $paginateRepairsUseCase->execute(50)->toArray();

        $repairs["data"] = $formatRepairsAction->execute($repairs["data"]);

        return Inertia::render('Repair/RepairIndex', [
            'repairs' => $repairs,
        ]);
    }

    public function create(
        SearchClientRequest        $request,
        GetDeviceCategoriesUseCase $getDeviceCategoriesUseCase,
        GetClientsUseCase          $getClientsUseCase,
        GetServiceUseCase          $getServiceUseCase,
        FindClientUseCase          $findClientUseCase,
    )
    {
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
        StoreRepairUseCase  $storeRepairUseCase,
    )
    {
        try {
            $validated = $request->validated();

            $storeRepairUseCase->execute($validated);

            return redirect()->route('repairs.index');
        } catch (Exception $exception) {
            return new ErrorResource($exception->getMessage());
        }
    }

    public function edit(Repair $repair)
    {
        $repair = $repair->load('reception', 'technician', 'device.deviceCategory', 'service');

        $statuses = RepairEnum::options();

        return Inertia::render('Repair/RepairEdit', [
            'repair' => $repair,
            'statuses' => $statuses,
        ]);
    }
}
