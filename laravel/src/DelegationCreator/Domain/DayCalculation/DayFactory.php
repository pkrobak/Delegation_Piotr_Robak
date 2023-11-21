<?php

namespace src\DelegationCreator\Domain\DayCalculation;

use DateTimeInterface;

class DayFactory
{
    const DAYS_AFTER_WHICH_IS_EXTRA_PRICE = 7;

    public function create(
        DateTimeInterface $comparedDate,
        DateTimeInterface $start,
        DateTimeInterface $end,
        int $increment,
        int $lastIncrementValue,
        DateTimeInterface $modifiedEnd
    ): DayStrategyInterface {
        if ($modifiedEnd->getTimestamp() === $comparedDate->getTimestamp()) {
            return new SkippedDay();
        }
        if ($increment === 0) {
            if ($this->shouldIncludeStartDay($start)) {
                return new StandardDay();
            }
            return new SkippedDay();
        }
        if ($lastIncrementValue === $increment) {
            if ($end->getTimestamp() === $comparedDate->getTimestamp()) {
                return new SkippedDay();
            }
            if ($this->shouldIncludeEndDay($end)) {
                if ($increment > self::DAYS_AFTER_WHICH_IS_EXTRA_PRICE) {
                    return new ExtraDay();
                }

                return new StandardDay();
            }
            return new SkippedDay();
        }
        if (!$this->isWorkDay($comparedDate) || in_array($increment, [0, $lastIncrementValue])) {
            return new SkippedDay();
        }
        if ($increment >= self::DAYS_AFTER_WHICH_IS_EXTRA_PRICE) {
            return new ExtraDay();
        }

        return new StandardDay();
    }

    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    private function shouldIncludeEndDay(DateTimeInterface $date): bool
    {
        $clonedEnd = clone $date;
        $clonedEnd->setTime(8, 0);

        return $date->getTimestamp() >= $clonedEnd->getTimestamp() && $this->isWorkDay($date);
    }

    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    private function isWorkDay(DateTimeInterface $date): bool
    {
        return (int)$date->format('N') <= 5;
    }

    /**
     * @param DateTimeInterface $startDate
     * @return bool
     */
    private function shouldIncludeStartDay(DateTimeInterface $startDate): bool
    {
        $clonedStart = clone $startDate;
        $clonedStart->setTime(16, 0);
        if ($startDate->getTimestamp() <= $clonedStart->getTimestamp() && $this->isWorkDay($startDate)) {
            return true;
        }

        return false;
    }
}
