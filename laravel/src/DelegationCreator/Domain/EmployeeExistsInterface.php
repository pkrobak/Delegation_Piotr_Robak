<?php

namespace src\DelegationCreator\Domain;

interface EmployeeExistsInterface
{
    public function exists(int $id): bool;
}
