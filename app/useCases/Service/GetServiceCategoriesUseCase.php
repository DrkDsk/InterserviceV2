<?php

namespace App\useCases\Service;

use App\Repositories\Contract\ServiceCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class GetServiceCategoriesUseCase
{
    public function __construct(private ServiceCategoryRepositoryInterface $serviceRepository)
    {
    }

    public function execute(): Collection
    {
        return $this->serviceRepository->getAll();
    }
}
