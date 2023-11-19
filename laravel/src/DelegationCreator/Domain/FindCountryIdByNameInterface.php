<?php

namespace src\DelegationCreator\Domain;

interface FindCountryIdByNameInterface
{
    public function findCountryByCode(string $countryCode): ?CountryEntity;
}
