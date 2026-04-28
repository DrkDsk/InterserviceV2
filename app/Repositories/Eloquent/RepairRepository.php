<?php

namespace App\Repositories\Eloquent;

use App\Models\Repair;
use App\Repositories\Contract\RepairRepositoryInterface;

class RepairRepository extends BaseRepository implements RepairRepositoryInterface
{
    public function __construct(Repair $model)
    {
        parent::__construct($model);
    }
}
