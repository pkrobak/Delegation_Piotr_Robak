<?php

namespace App\DelegationCreator\Domain\DayCalculation;

use DateTimeInterface;

readonly class DaysCollectionFactory
{
    public function __construct(
        private DayFactory $dayFactory
    )
    {
    }
    public function create(DateTimeInterface $start, DateTimeInterface $end, int $rate): DaysCollection
    {
        $collection = new DaysCollection();
        if ($start->getTimestamp() >= $end->getTimestamp()) {
            return $collection;
        }
        $i = -1;
        $currentDate = clone $start;
        $endCloned = clone $end;
        $endCloned->modify('midnight');
        $endCloned->modify('+1 day');
        $maxIncrementValue = $currentDate->diff($endCloned)->days;

        while ($currentDate <= $endCloned) {
            $i++;

            $dayStrategy = $this->dayFactory->create(
                $currentDate,
                $start,
                $end,
                $i,
                $maxIncrementValue,
                $endCloned
            );
            if (!$dayStrategy->isSkipped()) {
                $collection->add(new Day($rate, $dayStrategy->isDouble()));
            }
            $currentDate->modify('+1 day');
        }

        return $collection;
    }

}
