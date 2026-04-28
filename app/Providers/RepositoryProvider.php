<?php

namespace App\Providers;

use App\Repositories\Contract\ClientRepositoryInterface;
use App\Repositories\Contract\DeviceCategoryRepositoryInterface;
use App\Repositories\Contract\DeviceRepositoryInterface;
use App\Repositories\Contract\ReceptionRepositoryInterface;
use App\Repositories\Contract\RepairRepositoryInterface;
use App\Repositories\Contract\UserRepositoryInterface;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\DeviceCategoryRepository;
use App\Repositories\Eloquent\DeviceRepository;
use App\Repositories\Eloquent\ReceptionRepository;
use App\Repositories\Eloquent\RepairRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DeviceCategoryRepositoryInterface::class, DEviceCategoryRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(RepairRepositoryInterface::class, RepairRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
        $this->app->bind(ReceptionRepositoryInterface::class, ReceptionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
