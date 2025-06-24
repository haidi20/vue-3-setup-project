<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Tunai', 'description' => 'Pembayaran tunai langsung'],
            ['name' => 'Transfer', 'description' => 'Pembayaran melalui transfer bank'],
            ['name' => 'Kartu Kredit', 'description' => 'Pembayaran menggunakan kartu kredit'],
            ['name' => 'Kartu Debit', 'description' => 'Pembayaran menggunakan kartu debit'],
            ['name' => 'Cek', 'description' => 'Pembayaran menggunakan cek'],
            ['name' => 'Dompet Digital', 'description' => 'Pembayaran melalui dompet digital'],
            ['name' => 'Virtual Account', 'description' => 'Pembayaran melalui virtual account'],
            ['name' => 'QR Code', 'description' => 'Pembayaran menggunakan QR code'],
            ['name' => 'Cash on Delivery', 'description' => 'Pembayaran saat barang diterima'],
            ['name' => 'Giro', 'description' => 'Pembayaran via giro'],
        ];

        DB::table('payment_types')->insert($data);
    }
}
