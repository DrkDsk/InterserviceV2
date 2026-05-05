<?php

namespace App\Repositories\Eloquent;

use App\Models\Repair;
use App\Repositories\Contract\RepairRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RepairRepository extends BaseRepository implements RepairRepositoryInterface
{
    public function __construct(Repair $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->query()->with('technician', 'reception.client')->paginate($perPage);
    }
}
