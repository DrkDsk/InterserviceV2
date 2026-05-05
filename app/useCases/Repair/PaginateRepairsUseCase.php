<?php

namespace App\useCases\Repair;

use App\Repositories\Contract\RepairRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class PaginateRepairsUseCase
{
    public function __construct(private RepairRepositoryInterface $repairRepository)
    {
    }

    public function execute(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repairRepository->paginate($perPage);
    }
}
