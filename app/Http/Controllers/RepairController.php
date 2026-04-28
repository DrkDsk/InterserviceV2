<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRepairRequest;
use App\useCases\Client\GetClientsUseCase;
use App\useCases\DeviceCategory\GetDeviceCategoriesUseCase;
use Inertia\Inertia;

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

    public function store(CreateRepairRequest $request)
    {
        return response()->json($request->validated());
    }
}
