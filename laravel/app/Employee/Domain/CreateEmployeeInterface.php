<?php

namespace App\Employee\Domain;

interface CreateEmployeeInterface
{
    public function create(): int;
}
