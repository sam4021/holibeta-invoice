<?php

namespace App\Providers;

use App\Interfaces\MachineInterface;
use App\Repositories\MachineRepository;
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
        $this->app->bind(MachineRepository::class, MachineInterface::class);
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
