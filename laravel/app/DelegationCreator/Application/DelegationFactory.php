<?php

namespace App\DelegationCreator\Application;

use App\DelegationCreator\Domain\DayCalculation\DaysCollectionFactory;
use App\DelegationCreator\Domain\DelegationCommand;
use App\DelegationCreator\Domain\DelegationValueObject;
use App\DelegationCreator\Domain\EmployeeExistsInterface;
use App\DelegationCreator\Domain\Exception\CountryDoesNotExistException;
use App\DelegationCreator\Domain\Exception\EmployeeDoesntExistException;
use App\DelegationCreator\Domain\Exception\InvalidDateException;
use App\DelegationCreator\Domain\FindCountryIdByNameInterface;
use DateTime;

readonly class DelegationFactory
{

    public function __construct(
        private FindCountryIdByNameInterface $countryRepository,
        private EmployeeExistsInterface      $employeeRepository,
        private DaysCollectionFactory        $daysCollectionFactory
    ) {
    }

    /**
     * @throws InvalidDateException
     * @throws EmployeeDoesntExistException
     * @throws CountryDoesNotExistException
     */
    public function create(DelegationCommand $command): DelegationValueObject
    {
        if (!$this->employeeRepository->exists($command->employeeId)) {
            throw new EmployeeDoesntExistException('Employee with given ID doest not exists');
        }
        $countryEntity = $this->countryRepository->findCountryByCode($command->countryCode);
        if ($countryEntity === null) {
            throw new CountryDoesNotExistException('Country with given code does not exists');
        }
        // in theory, we don't need above queries because we validated it in form request and route model binding,
        // but I want to show you where to put that kind of logic

        try {
            $start = new \DateTimeImmutable($command->startDate);
        } catch (\Exception $exception) {
            throw new InvalidDateException('Invalid start date format');
        }
        try {
            $end = new \DateTimeImmutable($command->endDate);
        } catch (\Exception $exception) {
            throw new InvalidDateException('Invalid end date format');
        }

        return new DelegationValueObject(
            $start,
            $end,
            $command->employeeId,
            $countryEntity->id,
            $this->daysCollectionFactory->create(
                new DateTime($command->startDate),
                new DateTime($command->endDate),
                $countryEntity->rate
            )->sum()
        );
    }
}
