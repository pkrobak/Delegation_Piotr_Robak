<?php

namespace Tests\Feature;

use App\DelegationCreator\Application\Country;
use App\DelegationCreator\Application\Delegation;
use App\DelegationCreator\Application\Employee;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

class DelegationControllerTest extends TestCase
{
    public function test_store_notFoundEmployee(): void
    {
        $delegationCount = Delegation::count();
        $this->json(Request::METHOD_POST, 'api/employees/0')
            ->assertNotFound();
        $this->assertEquals($delegationCount, Delegation::count());
    }
    public function test_store_validationFails(): void
    {
        $delegationCount = Delegation::count();
        $employee = Employee::create();
        $this->json(Request::METHOD_POST, 'api/employees/' . $employee->id)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'start_date',
                'end_date',
                'country_code',
            ]);
        $this->assertEquals($delegationCount, Delegation::count());
    }
    public function test_store_validationFails_datesNotInAGoodRange(): void
    {
        $delegationCount = Delegation::count();
        $employee = Employee::create();
        $this->json(Request::METHOD_POST, 'api/employees/' . $employee->id, [
            'start_date' => Carbon::now()->format('Y-m-d h:i:s'),
            'end_date' => Carbon::now()->subDay()->format('Y-m-d h:i:s'),
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'end_date',
            ]);
        $this->assertEquals($delegationCount, Delegation::count());
    }
    public function test_store_validationFails_countryDoesNotExists(): void
    {
        $delegationCount = Delegation::count();
        $employee = Employee::create();
        $this->json(Request::METHOD_POST, 'api/employees/' . $employee->id, [
            'country_code' => Str::random(),
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country_code',
            ]);
        $this->assertEquals($delegationCount, Delegation::count());
    }
    public function test_store_success(): void
    {
        $this->assertNotEmpty(Country::get(), 'You need to seed database'); // usually I do it in the other way
        // I create a separate db and .env.testing where I put credential to db and I seed data per test
        // or run test seeders in test db
        $delegationCount = Delegation::count();
        $employee = Employee::create();
        $this->json(Request::METHOD_POST, 'api/employees/' . $employee->id, [
            'country_code' => Country::first()->code,
            'start_date' => '2023-11-20 00:00:00',
            'end_date' => '2023-11-21 00:00:00',
        ])
            ->assertCreated();
        $this->assertEquals(++$delegationCount, Delegation::count());
    }
}
