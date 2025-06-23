<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeders\Seeder;

class AccountNormalBalancesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'debit'],
            ['name' => 'kredit']
        ];

        DB::table('account_normal_balances')->insert($data);
    }
}
