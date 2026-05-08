<?php

namespace App\Repositories\Eloquent;

use App\Models\SetupCompany;
use App\Repositories\Contract\SetUpCompanyRepositoryInterface;

class SetupCompanyRepository extends BaseRepository implements SetUpCompanyRepositoryInterface
{
    public function __construct(SetupCompany $model)
    {
        parent::__construct($model);
    }
}
