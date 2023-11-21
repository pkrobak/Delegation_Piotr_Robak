<?php

namespace App\DelegationCreator\Domain;

interface FindCountryIdByNameInterface
{
    public function findCountryByCode(string $countryCode): ?CountryEntity;
}
