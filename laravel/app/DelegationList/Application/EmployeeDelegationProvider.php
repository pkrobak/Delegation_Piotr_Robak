<?php

namespace App\DelegationList\Application;

use App\DelegationList\Domain\EmployeeDelegationRepositoryInterface;
use App\DelegationList\Infrastructure\EmployeeDelegationEloquentRepository;
use Illuminate\Support\ServiceProvider;

class EmployeeDelegationProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(
            EmployeeDelegationRepositoryInterface::class,
            EmployeeDelegationEloquentRepository::class
        );
    }
}
