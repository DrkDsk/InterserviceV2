<?php

namespace App\Repositories\Eloquent;

use App\Models\Device;
use App\Repositories\Contract\DeviceRepositoryInterface;

class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{
    public function __construct(Device $model)
    {
        parent::__construct($model);
    }
}
