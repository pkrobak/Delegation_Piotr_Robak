<?php

namespace App\DelegationCreator\Domain;


readonly class CountryEntity
{
    public function __construct(
        public int $id,
        public string $code,
        public int $rate
    ) {
    }
}
