<?php

namespace src\DelegationCreator\Domain\DayCalculation;

readonly class SkippedDay implements DayStrategyInterface
{
    public function isSkipped(): bool
    {
        return true;
    }

    public function isDouble(): bool
    {
        return false;
    }
}
