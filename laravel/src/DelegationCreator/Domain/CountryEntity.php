<?php

namespace src\DelegationCreator\Domain;

readonly class CountryEntity
{
    public function __construct(
        public int $id,
        public string $code,
        public int $rate
    ) {
    }

    public function getAmount(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        $amount = 0;
        $difference = $start->diff($end);
        if ($difference->days !== false) {
            $amount += $difference->days * $this->rate;
        }
        if ($difference->h > 8) {
            $amount += $this->rate;
        }

        return $amount;
    }
}
