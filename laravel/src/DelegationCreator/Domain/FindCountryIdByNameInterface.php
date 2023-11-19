<?php

namespace src\DelegationCreator\Domain;

interface FindCountryIdByNameInterface
{
    public function findIdByCode(string $countryCode): ?int;
}
