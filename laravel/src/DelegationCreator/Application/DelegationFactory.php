<?php

namespace src\DelegationCreator\Application;

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
        private EmployeeExistsInterface      $employeeRepository
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
        $countryId = $this->countryRepository->findIdByCode($command->countryCode);
        if ($countryId === null) {
            throw new CountryDoesNotExistException('Country with given code does not exists');
        }
        // in theory, we don't need above queries, but I want to show you where to put that kind of logic

        return new DelegationValueObject(
            $command->startDate,
            $command->endDate,
            $command->employeeId,
            $countryId,
            0
        );
    }
}
