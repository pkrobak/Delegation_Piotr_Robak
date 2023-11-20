<?php

namespace src\DelegationCreator\Domain\DayCalculation;

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
        $maxIncrementValue = $currentDate->diff($endCloned)->days + 1;

        while ($currentDate <= $endCloned) {
            $i++;
            $dayStrategy = $this->dayFactory->create(
                $currentDate,
                $start,
                $end,
                $i,
                $maxIncrementValue
            );
            if (!$dayStrategy->isSkipped()) {
                var_dump(implode(' - ', [$dayStrategy->isDouble(), $i,  $currentDate->format('Y-m-d H:i:s')]));
                $collection->add(new Day($rate, $dayStrategy->isDouble()));
            }
            $currentDate->modify('+1 day');
        }

        return $collection;
    }

}
