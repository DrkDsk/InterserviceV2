<?php

namespace App\useCases\Client;

use App\Repositories\Contract\ClientRepositoryInterface;
use Illuminate\Support\Collection;

readonly class GetClientsUseCase
{
    public function __construct(protected ClientRepositoryInterface $clientRepository)
    {
    }

    public function execute(?string $search = null): Collection
    {
        return $this->clientRepository->search($search);
    }
}
