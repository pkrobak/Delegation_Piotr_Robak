<?php

namespace App\DelegationCreator\Domain\DayCalculation;

readonly class Day
{

    public function __construct(
        public int $rate,
        public bool $isDouble
    ) {
    }
}
