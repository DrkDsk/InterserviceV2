<?php

namespace App\Repositories\Contract;

use Illuminate\Pagination\LengthAwarePaginator;

interface RepairRepositoryInterface extends BaseRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
}
