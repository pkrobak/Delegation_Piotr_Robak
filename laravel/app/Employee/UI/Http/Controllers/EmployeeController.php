<?php

namespace App\Employee\UI\Http\Controllers;

use App\Employee\Application\CreateEmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController
{
    public function store(Request $request, CreateEmployeeService $service): JsonResponse
    {
        return new JsonResponse([
            'id' => $service->handle()
        ], 201);
    }
}
