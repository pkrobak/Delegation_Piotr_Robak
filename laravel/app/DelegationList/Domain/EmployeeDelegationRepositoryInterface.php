<?php

namespace App\DelegationList\Domain;

use App\DelegationList\Infrastructure\DelegationDTO;

interface EmployeeDelegationRepositoryInterface
{
    /**
     * @param int $employeeId
     * @return DelegationDTO[]
     */
    public function getDelegations(int $employeeId): array;
}
