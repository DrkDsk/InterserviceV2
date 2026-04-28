<?php

namespace App\useCases\Client;

use App\Repositories\Contract\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class GetClientsUseCase
{
    public function __construct(protected ClientRepositoryInterface $clientRepository)
    {
    }

    public function execute(): Collection
    {
        return $this->clientRepository->getAll();
    }
}
