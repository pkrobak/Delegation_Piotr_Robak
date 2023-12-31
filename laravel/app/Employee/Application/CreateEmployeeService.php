<?php

namespace App\Employee\Application;


use App\Employee\Domain\CreateEmployeeInterface;

readonly class CreateEmployeeService
{

    public function __construct(
        private CreateEmployeeInterface $createEmployee
    ) {
    }

    public function handle(): int
    {
        return $this->createEmployee->create();
    }
}
