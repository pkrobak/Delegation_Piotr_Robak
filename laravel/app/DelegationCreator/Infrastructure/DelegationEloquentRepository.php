<?php

namespace App\DelegationCreator\Infrastructure;

use App\DelegationCreator\Application\Delegation;
use App\DelegationCreator\Domain\CreateDelegationInterface;
use App\DelegationCreator\Domain\CreateDelegationRepositoryInterface;

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
