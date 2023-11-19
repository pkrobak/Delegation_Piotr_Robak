<?php

namespace src\Employee\Infrastructure;

use src\Employee\Application\Employee;
use src\Employee\Domain\CreateEmployeeInterface;

class EmployeeEloquentRepository implements CreateEmployeeInterface
{
    public function create(): int
    {
        return Employee::query()->create()->id;
    }
}
