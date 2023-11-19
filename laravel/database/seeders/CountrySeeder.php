<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    const COUNTIES = [
        [
            'name' => 'Polska',
            'code' => 'PL',
            'rate' => 1000
        ],
        [
            'name' => 'Niemcy',
            'code' => 'DE',
            'rate' => 5000
        ],
        [
            'name' => 'Wielka Brytania',
            'code' => 'GB',
            'rate' => 7500
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert(self::COUNTIES);
    }
}
