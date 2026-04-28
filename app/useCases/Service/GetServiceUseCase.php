<?php

namespace App\useCases\Service;

use App\Repositories\Contract\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class GetServiceUseCase
{
    public function __construct(private ServiceRepositoryInterface $serviceRepository)
    {
    }

    public function execute(): Collection
    {
        return $this->serviceRepository->getAll();
    }
}
