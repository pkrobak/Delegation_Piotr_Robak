<?php

namespace src\DelegationCreator\Infrastructure;

use src\DelegationCreator\Application\Country;
use src\DelegationCreator\Domain\FindCountryIdByNameInterface;

class CountryEloquentRepository implements FindCountryIdByNameInterface
{

    public function findIdByCode(string $countryCode): ?int
    {
        $country = Country::query()
            ->where('code', $countryCode)
            ->first();
        if ($country) {
            return $country->id;
        }

        return null;
    }
}
