<?php

namespace App\useCases\Client;

use App\Models\Client;
use App\Repositories\Contract\ClientRepositoryInterface;

readonly class FindClientUseCase
{
    public function __construct(private ClientRepositoryInterface $clientRepository)
    {
    }

    public function execute(int $id): ?Client
    {
        /* @var Client $client ; */
        $client = $this->clientRepository->find($id);
        return $client;
    }
}
