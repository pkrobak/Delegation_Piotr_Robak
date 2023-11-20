<?php

namespace src\DelegationCreator\Application;

use Illuminate\Support\ServiceProvider;
use src\DelegationCreator\Domain\CreateDelegationRepositoryInterface;
use src\DelegationCreator\Domain\EmployeeExistsInterface;
use src\DelegationCreator\Domain\FindCountryIdByNameInterface;
use src\DelegationCreator\Infrastructure\CountryEloquentRepository;
use src\DelegationCreator\Infrastructure\DelegationEloquentRepository;
use src\DelegationCreator\Infrastructure\EmployeeEloquentRepository;

class DelegationProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CreateDelegationRepositoryInterface::class, DelegationEloquentRepository::class);
        $this->app->bind(EmployeeExistsInterface::class, EmployeeEloquentRepository::class);
        $this->app->bind(FindCountryIdByNameInterface::class, CountryEloquentRepository::class);
    }
}
