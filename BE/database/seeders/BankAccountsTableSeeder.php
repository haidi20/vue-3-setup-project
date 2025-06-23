<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankAccountsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bank_accounts')->insert([
            [
                'account_estimate_id' => DB::table('account_estimates')->where('name', 'Bank BCA')->value('id'),
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder' => 'PT ABC'
            ],
            [
                'account_estimate_id' => DB::table('account_estimates')->where('name', 'Bank BRI')->value('id'),
                'bank_name' => 'BRI',
                'account_number' => '0987654321',
                'account_holder' => 'CV XYZ'
            ]
        ]);
    }
}
