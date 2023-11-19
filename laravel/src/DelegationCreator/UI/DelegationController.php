<?php

namespace src\DelegationCreator\UI;

use Illuminate\Http\JsonResponse;
use src\DelegationCreator\Application\CreateDelegationRequest;
use src\DelegationCreator\Application\CreateDelegationService;
use src\DelegationCreator\Domain\DelegationCommand;
use src\DelegationCreator\Domain\Exception\InvalidDateException;
use Symfony\Component\HttpFoundation\Response;

class DelegationController
{
    public function store(CreateDelegationRequest $request, CreateDelegationService $service): JsonResponse
    {
        try {
            $service->handle(new DelegationCommand(
                $request->getStartDate(),
                $request->getEndDate(),
                $request->getEmployeeId(),
                $request->getCountryCode()
            ));
        } catch (InvalidDateException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(
            // it was not in the task scope, but I would return DelegationCreator here
        );
    }
}
