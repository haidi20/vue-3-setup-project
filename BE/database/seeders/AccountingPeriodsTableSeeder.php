<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountingPeriodsTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'period_name' => 'Triwulan 1',
                'start_date'  => '2025-01-01',
                'end_date'    => '2025-03-31',
                'status'      => 'active',
            ],
            [
                'period_name' => 'Triwulan 2',
                'start_date'  => '2025-04-01',
                'end_date'    => '2025-06-30',
                'status'      => 'inactive',
            ],
            [
                'period_name' => 'Triwulan 3',
                'start_date'  => '2025-07-01',
                'end_date'    => '2025-09-30',
                'status'      => 'inactive',
            ],
            [
                'period_name' => 'Triwulan 4',
                'start_date'  => '2025-10-01',
                'end_date'    => '2025-12-31',
                'status'      => 'inactive',
            ],
        ];

        DB::table('accounting_periods')->insert($data);
    }
}
