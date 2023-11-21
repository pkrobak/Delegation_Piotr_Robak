<?php

namespace App\DelegationCreator\Application;

use App\DelegationCreator\Domain\CreateDelegationRepositoryInterface;
use App\DelegationCreator\Domain\EmployeeExistsInterface;
use App\DelegationCreator\Domain\FindCountryIdByNameInterface;
use App\DelegationCreator\Infrastructure\CountryEloquentRepository;
use App\DelegationCreator\Infrastructure\DelegationEloquentRepository;
use App\DelegationCreator\Infrastructure\EmployeeEloquentRepository;
use Illuminate\Support\ServiceProvider;

class DelegationProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CreateDelegationRepositoryInterface::class, DelegationEloquentRepository::class);
        $this->app->bind(EmployeeExistsInterface::class, EmployeeEloquentRepository::class);
        $this->app->bind(FindCountryIdByNameInterface::class, CountryEloquentRepository::class);
    }
}
