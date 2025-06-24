<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundingSourcesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Modal Sendiri', 'description' => 'Dana pribadi dari pemilik usaha'],
            ['name' => 'Pinjaman Keluarga', 'description' => 'Bantuan dana dari keluarga'],
            ['name' => 'Investasi Partner', 'description' => 'Modal dari partner bisnis'],
            ['name' => 'Laba Harian', 'description' => 'Pendapatan harian yang dijadikan modal tambahan'],
            ['name' => 'Kredit Bank', 'description' => 'Pinjaman dari bank atau koperasi'],
            ['name' => 'Tabungan Pribadi', 'description' => 'Dana hasil tabungan jangka panjang'],
            ['name' => 'Crowdfunding', 'description' => 'Dukungan dana dari komunitas atau platform crowdfunding'],
            ['name' => 'Penjualan Aset Lama', 'description' => 'Penjualan alat masak lama untuk tambah modal'],
            ['name' => 'Sponsorship Event', 'description' => 'Dana dari sponsor acara promosi'],
            ['name' => 'Subsidi Pemerintah UKM', 'description' => 'Bantuan dana dari program pengembangan UMKM'],
            ['name' => 'Hasil Investasi Lainnya', 'description' => 'Modal dari investasi lain seperti saham atau properti'],
            ['name' => 'Waralaba (Franchise)', 'description' => 'Dana awal dari pembelian paket waralaba'],
            ['name' => 'Pre-order Pelanggan', 'description' => 'Uang muka dari pelanggan sebelum produksi'],
            ['name' => 'Supplier Kredit', 'description' => 'Barang dikirim duluan, bayar nanti'],
            ['name' => 'Hadiah Kompetisi Bisnis', 'description' => 'Dana dari hadiah lomba atau inkubator bisnis'],
            ['name' => 'Pendanaan Online (Fintech)', 'description' => 'Pinjaman online dari platform fintech lokal'],
            ['name' => 'Leasing Alat Masak', 'description' => 'Pembiayaan alat masak via leasing'],
            ['name' => 'Alokasi Dana Darurat', 'description' => 'Dana darurat dialihkan untuk ekspansi usaha'],
            ['name' => 'Pendapatan Sewa Tempat', 'description' => 'Pendapatan dari sewa tempat usaha'],
            ['name' => 'Promo Diskon Awal', 'description' => 'Dana dari promo penjualan awal'],
            ['name' => 'Kerja Sama dengan GoFood/GrabFood', 'description' => 'Deposit awal dari mitra aplikasi pesan antar'],
            ['name' => 'Pendapatan Jual Merchandise', 'description' => 'Penjualan kaos, topi, dll untuk tambah modal'],
            ['name' => 'Bonus Karyawan', 'description' => 'Bonus bulanan dialokasikan sebagai tambahan operasional'],
            ['name' => 'Program Loyalty Customer', 'description' => 'Dana dari sistem deposit pelanggan setia'],
            ['name' => 'Partisipasi Komunitas Kuliner', 'description' => 'Dukungan dana dari komunitas makanan lokal'],
        ];

        DB::table('funding_sources')->insert($data);
    }
}
