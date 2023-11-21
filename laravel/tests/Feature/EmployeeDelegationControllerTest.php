<?php

namespace Feature;

use App\DelegationCreator\Application\Country;
use App\DelegationList\Application\Delegation;
use App\DelegationList\Application\Employee;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

class EmployeeDelegationControllerTest extends TestCase
{
    use WithFaker;
    public function test_list_noEmployee(): void
    {
        $this->json(Request::METHOD_GET, 'api/employees/0/delegations')
            ->assertNotFound();
    }

    public function test_list_empty(): void
    {
        $employee = Employee::create();
        $this->json(Request::METHOD_GET, 'api/employees/' . $employee->id . '/delegations')
            ->assertOk()
            ->assertJson([]);
    }

    public function test_list_notEmpty(): void
    {
        $this->assertNotEmpty(Country::get(), 'You need to seed database'); // usually I do it in the other way
        // I create a separate db and .env.testing where I put credential to db and I seed data per test
        // or run test seeders in test db
        $employee = Employee::create();
        $delegation = new Delegation();
        $delegation->country_id = Country::first()->id;
        $delegation->employee_id = $employee->id;
        $delegation->starts_at = Carbon::now()->subDay();
        $delegation->ends_at = Carbon::now();
        $delegation->amount_due = $this->faker->randomNumber(3);
        $delegation->save();
        $delegation = new Delegation();
        $delegation->country_id = Country::first()->id;
        $delegation->employee_id = $employee->id;
        $delegation->starts_at = Carbon::now()->subDays(9);
        $delegation->ends_at = Carbon::now()->subDays(6);
        $delegation->amount_due = $this->faker->randomNumber(3);
        $delegation->save();

        $this->json(Request::METHOD_GET, 'api/employees/' . $employee->id . '/delegations')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'start',
                        'end',
                        'country',
                        'amount_due',
                        'currency',
                    ]
                ]
            ]);
    }
}
