<?php

namespace App\Providers;

use App\Interfaces\MachineInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ShiftInterface;
use App\Repositories\MachineRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShiftRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MachineInterface::class,MachineRepository::class);
        $this->app->bind(ShiftInterface::class,ShiftRepository::class);
        $this->app->bind(ProductInterface::class,ProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
