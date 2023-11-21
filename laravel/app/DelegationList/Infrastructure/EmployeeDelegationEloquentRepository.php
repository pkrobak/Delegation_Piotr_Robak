<?php

namespace App\DelegationList\Infrastructure;

use App\DelegationList\Application\Delegation;
use App\DelegationList\Domain\EmployeeDelegationRepositoryInterface;

class EmployeeDelegationEloquentRepository implements EmployeeDelegationRepositoryInterface
{
    /**
     * @param int $employeeId
     * @return DelegationDTO[]
     */
    public function getDelegations(int $employeeId): array
    {
        return Delegation::query()
            ->with('country')
            ->where('employee_id', $employeeId)
            ->get()
            ->map(fn (Delegation $delegation) => new DelegationDTO(
                $delegation->starts_at,
                $delegation->ends_at,
                $delegation->country->code,
                $delegation->amount_due
            ))
            ->toArray();
    }
}
