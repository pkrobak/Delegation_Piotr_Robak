<?php

use App\DelegationCreator\UI\Http\Controllers\DelegationController;
use App\DelegationList\UI\Http\Controllers\EmployeeDelegationController;
use App\Employee\UI\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

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
Route::get('employees/{employee}/delegations', [EmployeeDelegationController::class, 'index']);
