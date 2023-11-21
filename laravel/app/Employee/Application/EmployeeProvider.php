<?php

namespace App\Employee\Application;

use App\Employee\Domain\CreateEmployeeInterface;
use App\Employee\Infrastructure\EmployeeEloquentRepository;
use Illuminate\Support\ServiceProvider;

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
