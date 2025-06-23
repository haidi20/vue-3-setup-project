<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['type_name' => 'Tunai', 'description' => 'Pembayaran tunai langsung'],
            ['type_name' => 'Transfer', 'description' => 'Pembayaran melalui transfer bank'],
            ['type_name' => 'Kartu Kredit', 'description' => 'Pembayaran menggunakan kartu kredit'],
            ['type_name' => 'Kartu Debit', 'description' => 'Pembayaran menggunakan kartu debit'],
            ['type_name' => 'Cek', 'description' => 'Pembayaran menggunakan cek'],
            ['type_name' => 'Dompet Digital', 'description' => 'Pembayaran melalui dompet digital'],
            ['type_name' => 'Virtual Account', 'description' => 'Pembayaran melalui virtual account'],
            ['type_name' => 'QR Code', 'description' => 'Pembayaran menggunakan QR code'],
            ['type_name' => 'Cash on Delivery', 'description' => 'Pembayaran saat barang diterima'],
            ['type_name' => 'Giro', 'description' => 'Pembayaran via giro'],
        ];

        DB::table('payment_types')->insert($data);
    }
}
