<?php

namespace App\DelegationCreator\Application;

use App\DelegationCreator\Domain\CreateDelegationRepositoryInterface;
use App\DelegationCreator\Domain\DelegationCommand;
use App\DelegationCreator\Domain\Exception\CountryDoesNotExistException;
use App\DelegationCreator\Domain\Exception\EmployeeDoesntExistException;
use App\DelegationCreator\Domain\Exception\InvalidDateException;

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
