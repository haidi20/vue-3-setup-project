<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationalUnitsTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Pemilik', 'description' => 'Pemilik usaha dan pengambil keputusan utama'],
            ['name' => 'Manajer Operasional', 'description' => 'Mengelola aktivitas harian dan SDM'],
            ['name' => 'Koki Utama', 'description' => 'Bertanggung jawab atas rasa dan penyajian makanan'],
            ['name' => 'Staff Dapur', 'description' => 'Asisten koki dalam memasak dan persiapan makanan'],
            ['name' => 'Kasir', 'description' => 'Melayani transaksi pembayaran pelanggan'],
            ['name' => 'Pelayan', 'description' => 'Melayani pelanggan di tempat'],
            ['name' => 'Gudang & Logistik', 'description' => 'Mengelola stok bahan baku dan perlengkapan'],
            ['name' => 'Marketing & Promosi', 'description' => 'Menyusun strategi promosi dan digital marketing'],
            ['name' => 'Keuangan', 'description' => 'Mencatat pemasukan dan pengeluaran usaha'],
            ['name' => 'Customer Service', 'description' => 'Menangani keluhan dan pertanyaan pelanggan'],
        ];

        DB::table('organizational_units')->insert($data);
    }
}
