<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationalUnitsTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['unit_name' => 'Pemilik', 'description' => 'Pemilik usaha dan pengambil keputusan utama'],
            ['unit_name' => 'Manajer Operasional', 'description' => 'Mengelola aktivitas harian dan SDM'],
            ['unit_name' => 'Koki Utama', 'description' => 'Bertanggung jawab atas rasa dan penyajian makanan'],
            ['unit_name' => 'Staff Dapur', 'description' => 'Asisten koki dalam memasak dan persiapan makanan'],
            ['unit_name' => 'Kasir', 'description' => 'Melayani transaksi pembayaran pelanggan'],
            ['unit_name' => 'Pelayan', 'description' => 'Melayani pelanggan di tempat'],
            ['unit_name' => 'Gudang & Logistik', 'description' => 'Mengelola stok bahan baku dan perlengkapan'],
            ['unit_name' => 'Marketing & Promosi', 'description' => 'Menyusun strategi promosi dan digital marketing'],
            ['unit_name' => 'Keuangan', 'description' => 'Mencatat pemasukan dan pengeluaran usaha'],
            ['unit_name' => 'Customer Service', 'description' => 'Menangani keluhan dan pertanyaan pelanggan'],
        ];

        DB::table('organizational_units')->insert($data);
    }
}
