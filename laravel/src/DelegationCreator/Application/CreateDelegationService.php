<?php

namespace src\DelegationCreator\Application;

use src\DelegationCreator\Domain\CreateDelegationRepositoryInterface;
use src\DelegationCreator\Domain\DelegationCommand;
use src\DelegationCreator\Domain\Exception\CountryDoesNotExistException;
use src\DelegationCreator\Domain\Exception\EmployeeDoesntExistException;
use src\DelegationCreator\Domain\Exception\InvalidDateException;

readonly class CreateDelegationService
{

    public function __construct(
        private CreateDelegationRepositoryInterface $repository,
        private DelegationFactory $factory
    ) {
    }

    /**
     * @throws InvalidDateException
     * @throws CountryDoesNotExistException
     * @throws EmployeeDoesntExistException
     */
    public function handle(DelegationCommand $command): void
    {
        $this->repository->create($this->factory->create($command));
    }
}
