<?php

namespace App\DelegationCreator\Domain;

interface CreateDelegationInterface
{
    public function getStartDate(): \DateTimeImmutable;
    public function getEndDate(): \DateTimeImmutable;

    public function getEmployeeId(): int;

    public function getCountryId(): int;

    public function getAmountDue(): int;
}
