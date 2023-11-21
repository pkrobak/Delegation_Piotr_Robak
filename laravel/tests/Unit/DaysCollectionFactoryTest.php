<?php

namespace Tests\Unit;

use App\DelegationCreator\Domain\DayCalculation\Day;
use App\DelegationCreator\Domain\DayCalculation\DayFactory;
use App\DelegationCreator\Domain\DayCalculation\DaysCollection;
use App\DelegationCreator\Domain\DayCalculation\DaysCollectionFactory;
use Exception;
use PHPUnit\Framework\TestCase;

class DaysCollectionFactoryTest extends TestCase
{
    /**
     * @param int $rate
     * @param string $startDate
     * @param string $endDate
     * @param int $amount
     * @return void
     * @throws Exception
     * @dataProvider dateProvider
     */
    public function test_getAmount(int $rate, string $startDate, string $endDate, int $amount): void
    {
        $factory = new DaysCollectionFactory(new DayFactory());
        $collection = $factory->create(new \DateTime($startDate), new \DateTime($endDate), $rate);
        $this->assertEquals($amount, $collection->sum());
    }

    public function test_sum_single()
    {
        $collection = new DaysCollection();
        $collection->add(new Day(1, false));
        $this->assertEquals(1, $collection->sum());
    }
    public function test_sum_multiple()
    {
        $collection = new DaysCollection();
        for ($i = 0; $i < 5; $i++) {
            var_dump($i);
            $collection->add(new Day(1, false));
        }
        $this->assertEquals(5, $collection->sum());
    }

    public function test_sum_multiple_double()
    {
        $rate = 1;
        $amount = 5;
        $isDouble = true;
        $collection = new DaysCollection();
        for ($i = 0; $i < $amount; $i++) {
            $collection->add(new Day($rate, $isDouble));
        }
        $this->assertEquals(($rate * $amount) * 2, $collection->sum());
    }

    public static function dateProvider(): array
    {
        return [
            // checks that include start date before 16
            [1, '2023-11-20 16:00:00', '2023-11-21 00:00:00', 1],
            [10, '2023-11-20 16:00:00', '2023-11-21 00:00:00', 10],

            // checks that does not include start date after 16
            [1, '2023-11-20 16:00:01', '2023-11-21 00:00:00', 0],
            [10, '2023-11-20 16:00:01', '2023-11-21 00:00:00', 0],

            // checks that include end date after 08
            [1, '2023-11-20 16:00:01', '2023-11-21 08:00:00', 1],
            [10, '2023-11-20 16:00:01', '2023-11-21 08:00:00', 10],

            // checks that does not include end date before 8
            [1, '2023-11-20 16:00:01', '2023-11-21 07:59:59', 0],
            [10, '2023-11-20 16:00:01', '2023-11-21 07:59:59', 0],

            // checks that does not include weekends
            [1, '2023-11-20 16:00:00', '2023-11-26 23:59:59', 5],
            [10, '2023-11-20 16:00:00', '2023-11-26 23:59:59', 50],
            [1, '2023-11-24 16:00:01', '2023-11-27 07:59:59', 0],

            // checks that include friday before weekend
            [1, '2023-11-24 16:00:00', '2023-11-27 07:59:59', 1],

            // checks that include monday after weekend
            [1, '2023-11-24 16:00:01', '2023-11-27 08:00:00', 1],

            // checks that does not work for reverse parameters
            [1, '2023-11-21 00:00:00', '2023-11-20 00:00:00', 0],

            // checks calculation when start is beginning of the day and end day is included
            [1, '2023-11-20 00:00:00', '2023-11-21 23:59:59', 2],

            // checks that count extra days properly
            [1, '2023-11-21 00:00:00', '2023-11-27 08:00:00', 5],
            [1, '2023-11-20 00:00:00', '2023-11-28 08:00:00', 9],
            [2, '2023-11-20 00:00:00', '2023-11-28 08:00:00', 18],
        ];
    }
}
