<?php

namespace App\Repositories\Eloquent;

use App\Models\Reception;
use App\Repositories\Contract\ReceptionRepositoryInterface;

class ReceptionRepository extends BaseRepository implements ReceptionRepositoryInterface
{
    public function __construct(Reception $model)
    {
        parent::__construct($model);
    }
}
