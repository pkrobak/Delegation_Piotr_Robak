<?php

namespace App\DelegationList\Infrastructure;

class DelegationDTO
{
    private string $start;
    private string $end;
    private string $countryCode;
    private int $amountDue;

    public function __construct(
        string $start,
        string $end,
        string $countryCode,
        int $amountDue
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->countryCode = $countryCode;
        $this->amountDue = $amountDue;
    }

    public function getStart(): string
    {
        return $this->start;
    }

    public function getEnd(): string
    {
        return $this->end;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getAmountDue(): int
    {
        return $this->amountDue;
    }
}
