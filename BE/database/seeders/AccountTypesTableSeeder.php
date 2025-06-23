<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Kas & Bank', 'description' => 'Aset likuid, termasuk kas tunai dan rekening bank'],
            ['name' => 'Piutang Usaha', 'description' => 'Uang yang belum diterima dari pelanggan'],
            ['name' => 'Persediaan', 'description' => 'Barang dagangan yang siap dijual'],
            ['name' => 'Aset Tetap', 'description' => 'Aset fisik jangka panjang'],
            ['name' => 'Utang Usaha', 'description' => 'Kewajiban kepada pemasok/pihak lain'],
            ['name' => 'Modal', 'description' => 'Investasi pemilik'],
            ['name' => 'Pendapatan', 'description' => 'Penerimaan dari penjualan barang/jasa'],
            ['name' => 'Beban Pokok Penjualan', 'description' => 'Biaya produksi/grosir produk'],
            ['name' => 'Beban', 'description' => 'Biaya operasional'],
            ['name' => 'Beban Lainnya', 'description' => 'Biaya tidak rutin'],
            ['name' => 'Pendapatan Lainnya', 'description' => 'Penerimaan non-penjualan'],
        ];

        DB::table('account_types')->insert($data);
    }
}
