<?php

namespace App\Employee\Infrastructure;

use App\Employee\Application\Employee;
use App\Employee\Domain\CreateEmployeeInterface;

class EmployeeEloquentRepository implements CreateEmployeeInterface
{
    public function create(): int
    {
        return Employee::query()->create()->id;
    }
}
