<?php

namespace src\DelegationCreator\Domain;

use src\DelegationCreator\Domain\Exception\InvalidDateException;

class DelegationValueObject implements CreateDelegationInterface
{

    private \DateTimeImmutable $startDate;
    private \DateTimeImmutable $endDate;
    private int $employeeId;
    private int $countryId;
    private int $amountDue;

    /**
     * @throws InvalidDateException
     */
    public function __construct(
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
        int    $employeeId,
        int    $countryId,
        int    $amountDue
    )
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        if ($this->startDate->getTimestamp() >= $this->endDate->getTimestamp()) {
            throw new InvalidDateException('Start date cannot be after end date');
        }
        $this->employeeId = $employeeId;
        $this->countryId = $countryId;
        $this->amountDue = $amountDue;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getCountryId(): int
    {
        return $this->countryId;
    }

    public function getAmountDue(): int
    {
        return $this->amountDue;
    }
}
