<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['type_name' => 'Tunai', 'description' => 'Pembayaran tunai langsung'],
            ['type_name' => 'QRIS', 'description' => 'Pembayaran menggunakan QR Code standar BI'],
            ['type_name' => 'GoPay', 'description' => 'Pembayaran melalui dompet digital Gojek'],
            ['type_name' => 'OVO', 'description' => 'Pembayaran melalui dompet digital OVO'],
            ['type_name' => 'DANA', 'description' => 'Pembayaran melalui dompet digital DANA'],
            ['type_name' => 'ShopeePay', 'description' => 'Pembayaran melalui ShopeePay'],
            ['type_name' => 'LinkAja', 'description' => 'Pembayaran melalui dompet digital LinkAja'],
            ['type_name' => 'Kartu Debit', 'description' => 'Pembayaran menggunakan kartu debit'],
            ['type_name' => 'Kartu Kredit', 'description' => 'Pembayaran menggunakan kartu kredit'],
            // ['type_name' => 'COD', 'description' => 'Cash on delivery (bayar saat terima)'],
            ['type_name' => 'Bank Transfer', 'description' => 'Transfer melalui bank'],
        ];

        DB::table('transaction_types')->insert($data);
    }
}
