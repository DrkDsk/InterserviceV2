<?php

namespace App\Repositories\Contract;

use Illuminate\Support\Collection;

interface ClientRepositoryInterface extends BaseRepositoryInterface
{
    public function search(?string $search = null): Collection;
}
