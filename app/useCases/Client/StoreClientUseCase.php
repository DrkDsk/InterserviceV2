<?php

namespace App\useCases\Client;

use App\Repositories\Contract\ClientRepositoryInterface;

readonly class StoreClientUseCase
{
    public function __construct(private ClientRepositoryInterface $clientRepository)
    {
    }

    public function execute(array $data)
    {
        return $this->clientRepository->create($data);
    }
}
