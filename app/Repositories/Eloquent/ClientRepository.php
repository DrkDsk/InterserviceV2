<?php

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Repositories\Contract\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    public function search(?string $search = null): Collection
    {
        return $this->model->query()->when($search, function ($query, $search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower($search) . '%']);
        })->limit(100)->get();
    }
}
