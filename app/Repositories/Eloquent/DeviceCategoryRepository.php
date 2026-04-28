<?php

namespace App\Repositories\Eloquent;

use App\Models\DeviceCategory;
use App\Repositories\Contract\DeviceCategoryRepositoryInterface;

class DeviceCategoryRepository extends BaseRepository implements DeviceCategoryRepositoryInterface
{
    public function __construct(DeviceCategory $model)
    {
        parent::__construct($model);
    }
}
