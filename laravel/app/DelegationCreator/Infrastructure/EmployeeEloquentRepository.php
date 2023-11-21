<?php

namespace App\DelegationCreator\Infrastructure;

use App\DelegationCreator\Application\Employee;
use App\DelegationCreator\Domain\EmployeeExistsInterface;

class EmployeeEloquentRepository implements EmployeeExistsInterface
{

    public function exists(int $id): bool
    {
        return Employee::query()->find($id)->exists();
    }
}
