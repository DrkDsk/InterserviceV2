<?php

namespace App\useCases\Reception;

use App\Models\Reception;
use App\Repositories\Contract\ReceptionRepositoryInterface;
use Illuminate\Support\Str;

readonly class StoreReceptionUseCase
{
    public function __construct(protected ReceptionRepositoryInterface $receptionRepository)
    {
    }

    public function execute(array $data): Reception
    {
        $now = now();

        $millisecond = $now->millisecond;

        $data = array_merge($data, [
            "received_at" => $now,
            "created_by" => auth()->id() ?? 1,
            "folio" => $millisecond . "-" . Str::random(4),
        ]);

        return $this->receptionRepository->create($data);
    }
}
