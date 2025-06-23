<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Seeder classes dan deskripsi:
         *
         * master
         * - AccountEstimatesTableSeeder      → Akun Perkiraan
         * - AccountingPeriodsTableSeeder     → Periode Akuntansi
         * - BankAccountsTableSeeder          → Rekening Bank
         * - FundingSourcesTableSeeder        → Sumber Dana
         * - TransactionTypesTableSeeder      → Jenis Transaksi
         * - PaymentTypesTableSeeder          → Jenis Pembayaran
         * - OrganizationalUnitsTableSeeder   → Unit Organisasi
         *
         * keuangan
         * - CashBooksTableSeeder             → Pembukuan Kas
         */
        $this->call([
            // data dasar
            AccountCategoriesTableSeeder::class,
            AccountTypesTableSeeder::class,
            AccountEstimatesTableSeeder::class,
            AccountingPeriodsTableSeeder::class,
            BankAccountsTableSeeder::class,
            FundingSourcesTableSeeder::class,
            TransactionTypesTableSeeder::class,
            PaymentTypesTableSeeder::class,
            OrganizationalUnitsTableSeeder::class,


            // keuangan
            CashBooksTableSeeder::class,
        ]);
    }
}
