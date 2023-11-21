<?php

namespace App\DelegationCreator\Domain;

interface EmployeeExistsInterface
{
    public function exists(int $id): bool;
}
