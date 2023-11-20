<?php

namespace Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use src\DelegationCreator\Domain\DayCalculation\DayFactory;
use src\DelegationCreator\Domain\DayCalculation\DaysCollectionFactory;

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

            // checks that count extra days properly
            [1, '2023-11-21 00:00:00', '2023-11-27 08:00:00', 5],
            [1, '2023-11-20 00:00:00', '2023-11-28 08:00:00', 8],
            [2, '2023-11-20 00:00:00', '2023-12-01 08:00:00', 15],
        ];
    }
}
