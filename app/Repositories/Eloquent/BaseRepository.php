<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contract\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function limit(int $limit = 100): Collection
    {
        return $this->model->query()->limit($limit)->get();
    }

    public function find(int $id): ?Model
    {
        return $this->model->query()->where('id', $id)->first();
    }

    public function getByField(string $field, string $value): ?Model
    {
        return $this->model
            ->query()
            ->where($field, $value)
            ->first();
    }

    public function create(array $data): ?Model
    {
        return $this->model->query()->create($data);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->query()->paginate($perPage);
    }
}
