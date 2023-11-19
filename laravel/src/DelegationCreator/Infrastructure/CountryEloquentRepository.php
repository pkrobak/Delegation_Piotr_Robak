<?php

namespace src\DelegationCreator\Infrastructure;

use src\DelegationCreator\Application\Country;
use src\DelegationCreator\Domain\CountryEntity;
use src\DelegationCreator\Domain\FindCountryIdByNameInterface;

class CountryEloquentRepository implements FindCountryIdByNameInterface
{

    public function findCountryByCode(string $countryCode): ?CountryEntity
    {
        $country = Country::query()
            ->where('code', $countryCode)
            ->first();
        if ($country) {
            return new CountryEntity(
                $country->id,
                $country->code,
                $country->rate
            );
        }

        return null;
    }
}
