<?php

namespace App\Repositories\Eloquent;

use App\Models\Service;
use App\Repositories\Contract\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }
}
