<?php

namespace src\DelegationCreator\UI;

use Illuminate\Http\JsonResponse;
use src\DelegationCreator\Application\CreateDelegationRequest;
use src\DelegationCreator\Application\CreateDelegationService;
use src\DelegationCreator\Application\Employee;
use src\DelegationCreator\Domain\DelegationCommand;
use src\DelegationCreator\Domain\Exception\CountryDoesNotExistException;
use src\DelegationCreator\Domain\Exception\EmployeeDoesntExistException;
use src\DelegationCreator\Domain\Exception\InvalidDateException;
use Symfony\Component\HttpFoundation\Response;

class DelegationController
{
    public function store(
        CreateDelegationRequest $request,
        Employee $employee,
        CreateDelegationService $service
    ): JsonResponse {
        try {
            $service->handle(new DelegationCommand(
                $request->getStartDate(),
                $request->getEndDate(),
                $employee->id,
                $request->getCountryCode()
            ));
        } catch (InvalidDateException|EmployeeDoesntExistException|CountryDoesNotExistException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], // it was not in the task scope, but I would return created delegation here
            // and this is common problem in cqs / cqrs, but I did not implement cqs properly here
        Response::HTTP_CREATED
        );
    }
}
