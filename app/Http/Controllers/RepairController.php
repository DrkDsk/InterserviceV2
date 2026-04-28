<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRepairRequest;
use App\Http\Resources\ErrorResource;
use App\useCases\Client\GetClientsUseCase;
use App\useCases\DeviceCategory\GetDeviceCategoriesUseCase;
use App\useCases\Repair\StoreRepairUseCase;
use Exception;
use Inertia\Inertia;
use Throwable;

class RepairController extends Controller
{
    public function index()
    {
        return Inertia::render('Repair/RepairIndex');
    }

    public function create(GetDeviceCategoriesUseCase $getDeviceCategoriesUseCase, GetClientsUseCase $getClientsUseCase)
    {
        $deviceCategories = $getDeviceCategoriesUseCase->execute();
        $clients = $getClientsUseCase->execute();

        return Inertia::render('Repair/RepairCreate', [
            'deviceCategories' => $deviceCategories,
            'clients' => $clients,
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
}
