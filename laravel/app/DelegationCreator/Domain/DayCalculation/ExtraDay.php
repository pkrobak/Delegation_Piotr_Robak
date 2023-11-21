<?php

namespace App\DelegationCreator\Domain\DayCalculation;

readonly class ExtraDay implements DayStrategyInterface
{
    public function isSkipped(): bool
    {
        return false;
    }

    public function isDouble(): bool
    {
        return true;
    }
}
