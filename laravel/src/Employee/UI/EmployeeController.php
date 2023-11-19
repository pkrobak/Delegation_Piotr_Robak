<?php

namespace src\Employee\UI;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use src\Employee\Application\CreateEmployeeService;

class EmployeeController
{
    public function store(Request $request, CreateEmployeeService $service): JsonResponse
    {
        return new JsonResponse([
            'id' => $service->handle()
        ], 201);
    }
}
