<?php

namespace App\Providers;

use App\Interfaces\VehicleInterface;
use App\Repositories\VehicleRepository;
use App\Interfaces\SupplierInterface;
use App\Repositories\SupplierRepository;
use App\Interfaces\SecurityCheckInterface;
use App\Repositories\SecurityCheckRepository;
use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(VehicleInterface::class, VehicleRepository::class);
        $this->app->bind(SupplierInterface::class, SupplierRepository::class);
        $this->app->bind(SecurityCheckInterface::class, SecurityCheckRepository::class);
        $this->app->bind(UserRepository::class, UserInterface::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
