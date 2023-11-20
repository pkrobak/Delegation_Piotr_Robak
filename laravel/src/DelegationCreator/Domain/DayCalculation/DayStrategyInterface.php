<?php

namespace src\DelegationCreator\Domain\DayCalculation;

interface DayStrategyInterface
{
    public function isSkipped(): bool;

    public function isDouble(): bool;
}
