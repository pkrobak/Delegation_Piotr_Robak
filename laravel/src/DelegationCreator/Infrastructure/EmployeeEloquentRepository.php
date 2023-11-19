<?php

namespace src\DelegationCreator\Infrastructure;

use src\DelegationCreator\Application\Employee;
use src\DelegationCreator\Domain\EmployeeExistsInterface;

class EmployeeEloquentRepository implements EmployeeExistsInterface
{

    public function exists(int $id): bool
    {
        return Employee::query()->find($id)->exists();
    }
}
