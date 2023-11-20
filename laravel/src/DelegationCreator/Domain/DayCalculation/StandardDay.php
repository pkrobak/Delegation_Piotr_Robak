<?php

namespace src\DelegationCreator\Domain\DayCalculation;

readonly class StandardDay implements DayStrategyInterface
{
    public function isSkipped(): bool
    {
        return false;
    }

    public function isDouble(): bool
    {
        return false;
    }
}
