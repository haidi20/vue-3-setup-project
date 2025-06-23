<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AccountCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Aset'],
            ['name' => 'Liabilitas'],
            ['name' => 'Ekuitas'],
            ['name' => 'Pendapatan'],
            ['name' => 'Beban']
        ];

        DB::table('account_categories')->insert($data);
    }
}
