<?php

namespace App\Repositories\Contract;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function getAll(): Collection;

    public function limit(int $limit = 100): Collection;

    public function find(int $id): ?Model;

    public function getByField(string $field, string $value): ?Model;

    public function create(array $data): ?Model;

    public function paginate(int $perPage = 10): LengthAwarePaginator;
}

