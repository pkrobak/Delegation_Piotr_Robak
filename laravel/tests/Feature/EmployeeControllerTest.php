<?php

namespace Tests\Feature;

use App\Employee\Application\Employee;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    public function test_store_success(): void
    {
        $usersCount = Employee::count();
        $this->json(Request::METHOD_POST, 'api/employees')
            ->assertCreated()
            ->assertJsonStructure([
                'id'
            ]);
        $this->assertEquals(++$usersCount, Employee::count());
    }
}
