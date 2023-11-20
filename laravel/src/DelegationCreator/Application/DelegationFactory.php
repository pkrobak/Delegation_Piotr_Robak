<?php

namespace src\DelegationCreator\Application;

use DateTime;
use src\DelegationCreator\Domain\DayCalculation\DaysCollectionFactory;
use src\DelegationCreator\Domain\DelegationCommand;
use src\DelegationCreator\Domain\DelegationValueObject;
use src\DelegationCreator\Domain\EmployeeExistsInterface;
use src\DelegationCreator\Domain\Exception\CountryDoesNotExistException;
use src\DelegationCreator\Domain\Exception\EmployeeDoesntExistException;
use src\DelegationCreator\Domain\Exception\InvalidDateException;
use src\DelegationCreator\Domain\FindCountryIdByNameInterface;

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
