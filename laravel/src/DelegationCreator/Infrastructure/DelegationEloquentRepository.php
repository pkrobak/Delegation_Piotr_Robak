<?php

namespace src\DelegationCreator\Infrastructure;

use src\DelegationCreator\Application\Delegation;
use src\DelegationCreator\Domain\CreateDelegationInterface;
use src\DelegationCreator\Domain\CreateDelegationRepositoryInterface;

class DelegationEloquentRepository implements CreateDelegationRepositoryInterface
{

    public function create(CreateDelegationInterface $delegation): void
    {
        $delegationModel = new Delegation();
        $delegationModel->employee_id = $delegation->getEmployeeId();
        $delegationModel->country_id = $delegation->getCountryId();
        $delegationModel->amount_due = $delegation->getAmountDue();
        $delegationModel->starts_at = $delegation->getStartDate();
        $delegationModel->ends_at = $delegation->getEndDate();
        $delegationModel->save();
    }
}
