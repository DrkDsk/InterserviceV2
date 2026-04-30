<?php

namespace App\useCases\Reception;

use App\Repositories\Contract\ReceptionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class PaginateReceptionUseCase
{
    public function __construct(private ReceptionRepositoryInterface $receptionRepository)
    {
    }

    public function execute(int $perPage = 10): LengthAwarePaginator
    {
        return $this->receptionRepository->paginate($perPage);
    }
}
