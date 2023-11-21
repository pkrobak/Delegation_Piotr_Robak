<?php

namespace App\DelegationCreator\UI\Http\Controllers;

use App\DelegationCreator\Application\CreateDelegationRequest;
use App\DelegationCreator\Application\CreateDelegationService;
use App\DelegationCreator\Application\Employee;
use App\DelegationCreator\Domain\DelegationCommand;
use App\DelegationCreator\Domain\Exception\CountryDoesNotExistException;
use App\DelegationCreator\Domain\Exception\EmployeeDoesntExistException;
use App\DelegationCreator\Domain\Exception\InvalidDateException;
use Illuminate\Http\JsonResponse;
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
