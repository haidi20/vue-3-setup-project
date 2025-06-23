<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundingSourcesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['source_name' => 'Modal Sendiri', 'description' => 'Dana pribadi dari pemilik usaha'],
            ['source_name' => 'Pinjaman Keluarga', 'description' => 'Bantuan dana dari keluarga'],
            ['source_name' => 'Investasi Partner', 'description' => 'Modal dari partner bisnis'],
            ['source_name' => 'Laba Harian', 'description' => 'Pendapatan harian yang dijadikan modal tambahan'],
            ['source_name' => 'Kredit Bank', 'description' => 'Pinjaman dari bank atau koperasi'],
            ['source_name' => 'Tabungan Pribadi', 'description' => 'Dana hasil tabungan jangka panjang'],
            ['source_name' => 'Crowdfunding', 'description' => 'Dukungan dana dari komunitas atau platform crowdfunding'],
            ['source_name' => 'Penjualan Aset Lama', 'description' => 'Penjualan alat masak lama untuk tambah modal'],
            ['source_name' => 'Sponsorship Event', 'description' => 'Dana dari sponsor acara promosi'],
            ['source_name' => 'Subsidi Pemerintah UKM', 'description' => 'Bantuan dana dari program pengembangan UMKM'],
            ['source_name' => 'Hasil Investasi Lainnya', 'description' => 'Modal dari investasi lain seperti saham atau properti'],
            ['source_name' => 'Waralaba (Franchise)', 'description' => 'Dana awal dari pembelian paket waralaba'],
            ['source_name' => 'Pre-order Pelanggan', 'description' => 'Uang muka dari pelanggan sebelum produksi'],
            ['source_name' => 'Supplier Kredit', 'description' => 'Barang dikirim duluan, bayar nanti'],
            ['source_name' => 'Hadiah Kompetisi Bisnis', 'description' => 'Dana dari hadiah lomba atau inkubator bisnis'],
            ['source_name' => 'Pendanaan Online (Fintech)', 'description' => 'Pinjaman online dari platform fintech lokal'],
            ['source_name' => 'Leasing Alat Masak', 'description' => 'Pembiayaan alat masak via leasing'],
            ['source_name' => 'Alokasi Dana Darurat', 'description' => 'Dana darurat dialihkan untuk ekspansi usaha'],
            ['source_name' => 'Pendapatan Sewa Tempat', 'description' => 'Pendapatan dari sewa tempat usaha'],
            ['source_name' => 'Promo Diskon Awal', 'description' => 'Dana dari promo penjualan awal'],
            ['source_name' => 'Kerja Sama dengan GoFood/GrabFood', 'description' => 'Deposit awal dari mitra aplikasi pesan antar'],
            ['source_name' => 'Pendapatan Jual Merchandise', 'description' => 'Penjualan kaos, topi, dll untuk tambah modal'],
            ['source_name' => 'Bonus Karyawan', 'description' => 'Bonus bulanan dialokasikan sebagai tambahan operasional'],
            ['source_name' => 'Program Loyalty Customer', 'description' => 'Dana dari sistem deposit pelanggan setia'],
            ['source_name' => 'Partisipasi Komunitas Kuliner', 'description' => 'Dukungan dana dari komunitas makanan lokal'],
        ];

        DB::table('funding_sources')->insert($data);
    }
}
