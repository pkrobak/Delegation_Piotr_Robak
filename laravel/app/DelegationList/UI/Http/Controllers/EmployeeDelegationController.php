<?php

namespace App\DelegationList\UI\Http\Controllers;

use App\DelegationList\Application\DelegationResource;
use App\DelegationList\Application\Employee;
use App\DelegationList\Application\ListDelegationQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeDelegationController extends Controller
{
    public function index(Request $request, Employee $employee, ListDelegationQuery $query): JsonResponse
    {
        return DelegationResource::collection($query->handle($employee->id))->toResponse($request);
    }
}
