<?php

namespace src\DelegationCreator\Domain;

readonly class DelegationCommand
{

    public function __construct(
        public string $startDate,
        public string $endDate,
        public int    $employeeId,
        public string $countryCode
    )
    {
    }
}
