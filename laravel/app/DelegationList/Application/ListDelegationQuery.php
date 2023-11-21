<?php

namespace App\DelegationList\Application;

use App\DelegationList\Domain\EmployeeDelegationRepositoryInterface;

class ListDelegationQuery
{
    private EmployeeDelegationRepositoryInterface $repository;

    public function __construct(EmployeeDelegationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $employeeId): array
    {
        return $this->repository->getDelegations($employeeId);
    }
}
