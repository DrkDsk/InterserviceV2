<?php

namespace App\useCases\Repair;

use App\Models\Repair;
use App\Repositories\Contract\RepairRepositoryInterface;
use App\useCases\Client\StoreClientUseCase;
use App\useCases\Device\StoreDeviceUseCase;
use App\useCases\Reception\StoreReceptionUseCase;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class StoreRepairUseCase
{
    public function __construct(protected RepairRepositoryInterface $repairRepository,
                                protected StoreReceptionUseCase     $storeReceptionUseCase,
                                protected StoreDeviceUseCase        $storeDeviceUseCase,
                                protected StoreClientUseCase        $storeClientUseCase)
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(array $validated): Repair
    {
        try {
            return DB::transaction(function () use ($validated) {

                if (!$validated['client_id']) {
                    $client = $this->storeClientUseCase->execute([
                        "name" => $validated['customer_name'],
                        "phone" => $validated['customer_phone']
                    ]);

                    $validated['client_id'] = $client->id;
                }

                $reception = [
                    "client_id" => $validated['client_id'],
                    "customer_name" => $validated['customer_name'],
                    "customer_phone" => $validated['customer_phone'],
                    "notes" => $validated['notes'],
                ];

                $storedReception = $this->storeReceptionUseCase->execute($reception);

                $device = [
                    "device_category_id" => $validated['device_category_id'],
                    "reception_id" => $storedReception->id,
                    "brand" => $validated['brand'],
                    "model" => $validated['model'],
                    "serial_number" => $validated['serial_number'],
                    "inventory_number" => $validated['inventory_number'],
                    "password" => $validated['password'],
                    "issue" => $validated['issue'],
                    "observations" => $validated['observations'],
                    "accessories" => $validated['accessories'],
                ];

                $storedDevice = $this->storeDeviceUseCase->execute($device);

                $repairData = [
                    "reception_id" => $storedReception->id,
                    "device_id" => $storedDevice->id,
                    "service_id" => $validated['service_id'],
                    "issue" => $validated['issue'],
                    "observations" => $validated['observations'],
                ];

                $repairData = array_merge($repairData, [
                    "technician_id" => auth()->id(),
                ]);

                return $this->repairRepository->create($repairData);
            });
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}
