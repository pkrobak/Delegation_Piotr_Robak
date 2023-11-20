<?php

namespace src\DelegationCreator\Domain;


use DateTimeInterface;

readonly class CountryEntity
{
    public function __construct(
        public int $id,
        public string $code,
        public int $rate
    ) {
    }

    public function getAmount(DateTimeInterface $start, DateTimeInterface $end): int
    {
        if ($start->getTimestamp() >= $end->getTimestamp()) {
            return 0;
        }
        $difference = $start->diff($end);
        if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
            if ($difference->h >= 8) {
                return $this->rate;
            }

            return 0;
        }

        return $this->getFullyQualifiedDays($start, $end) * $this->rate;
    }

    private function getFullyQualifiedDays(DateTimeInterface $start, DateTimeInterface $end): int
    {
        $start = clone $start;
        $end = clone $end;
        $days = 0;

        if ($this->shouldIncludeStartDay($start)) {
            $days++;
        }
        $start->modify('+1 day'); // this is done to does not include start day in while loop
        $start->modify('midnight');

        if ($this->shouldIncludeEndDay($end)) {
            $days++;
        }
        $end->modify('midnight');
        $end->modify('-1 hour'); // this is done to does not include last day in while loop

        if ($start->getTimestamp() >= $end->getTimestamp()) {
            return $days;
        }

        return $this->getDaysBetween($start, $end) + $days;
    }

    /**
     * @param DateTimeInterface $start
     * @return bool
     */
    public function shouldIncludeStartDay(DateTimeInterface $start): bool
    {
        $clonedStart = clone $start;
        $clonedStart->setTime(16, 0);
        if ($start->getTimestamp() <= $clonedStart->getTimestamp() && $this->isWorkDay($start)) {
            return true;
        }

        return false;
    }

    /**
     * @param DateTimeInterface $end
     * @return bool
     */
    public function shouldIncludeEndDay(DateTimeInterface $end): bool
    {
        $clonedEnd = clone $end;
        $clonedEnd->setTime(8, 0);

        return $end->getTimestamp() >= $clonedEnd->getTimestamp() && $this->isWorkDay($end);
    }

    /**
     * @param DateTimeInterface $start
     * @param DateTimeInterface $end
     * @return int
     */
    public function getDaysBetween(DateTimeInterface $start, DateTimeInterface $end): int
    {
        $days = 0;
        while ($start <= $end) {
            if ($this->isWorkDay($start)) {
                $days++;
            }

            $start->modify('+1 day');
        }
        return $days;
    }

    /**
     * @param DateTimeInterface $end
     * @return bool
     */
    public function isWorkDay(DateTimeInterface $end): bool
    {
        return (int)$end->format('N') <= 5;
    }
}
