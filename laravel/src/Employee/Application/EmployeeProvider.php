<?php

namespace src\Employee\Application;

use Illuminate\Support\ServiceProvider;
use src\Employee\Domain\CreateEmployeeInterface;
use src\Employee\Infrastructure\EmployeeEloquentRepository;

class EmployeeProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CreateEmployeeInterface::class,
            EmployeeEloquentRepository::class
        );
    }
}
