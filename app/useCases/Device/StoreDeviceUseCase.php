<?php

namespace App\useCases\Device;


use App\Repositories\Contract\DeviceRepositoryInterface;

readonly class StoreDeviceUseCase
{
    public function __construct(protected DeviceRepositoryInterface $deviceRepository)
    {
    }

    public function execute(array $data)
    {
        return $this->deviceRepository->create($data);
    }
}
