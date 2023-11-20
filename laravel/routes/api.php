<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use src\DelegationCreator\UI\DelegationController;
use src\Employee\UI\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('employees', [EmployeeController::class, 'store']);
Route::post('employees/{employee}', [DelegationController::class, 'store']);
