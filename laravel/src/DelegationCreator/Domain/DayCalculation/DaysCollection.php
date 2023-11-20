<?php

namespace src\DelegationCreator\Domain\DayCalculation;

class DaysCollection
{
    /**
     * @var array<Day>
     */
    private array $days = [];

    public function add(Day $day): void
    {
        $this->days[] = $day;
    }

    public function sum(): int
    {
        return array_reduce(
            $this->days,
            fn (int $carry, Day $day) => $carry + ($day->isDouble
                ? $day->rate * 2
                : $day->rate),
            0
        );
    }
}
