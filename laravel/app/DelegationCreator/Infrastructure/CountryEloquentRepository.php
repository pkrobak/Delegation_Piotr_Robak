<?php

namespace App\DelegationCreator\Infrastructure;

use App\DelegationCreator\Application\Country;
use App\DelegationCreator\Domain\CountryEntity;
use App\DelegationCreator\Domain\FindCountryIdByNameInterface;

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
