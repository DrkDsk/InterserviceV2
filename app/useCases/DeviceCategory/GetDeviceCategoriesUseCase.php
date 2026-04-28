<?php

namespace App\useCases\DeviceCategory;

use App\Repositories\Contract\DeviceCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class GetDeviceCategoriesUseCase
{
    public function __construct(protected DeviceCategoryRepositoryInterface $deviceCategoryRepository)
    {
    }

    public function execute(): Collection
    {
        return $this->deviceCategoryRepository->getAll();
    }
}
