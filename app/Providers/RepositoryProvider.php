<?php

namespace App\Providers;

use App\Repositories\Contract\DeviceCategoryRepositoryInterface;
use App\Repositories\Contract\UserRepositoryInterface;
use App\Repositories\Eloquent\DeviceCategoryRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
