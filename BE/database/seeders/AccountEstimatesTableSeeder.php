<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountEstimatesTableSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID dari account_categories berdasarkan name
        $asetId = DB::table('account_categories')->where('name', 'Aset')->value('id');
        $liabilitasId = DB::table('account_categories')->where('name', 'Liabilitas')->value('id');
        $ekuitasId = DB::table('account_categories')->where('name', 'Ekuitas')->value('id');
        $pendapatanId = DB::table('account_categories')->where('name', 'Pendapatan')->value('id');
        $bebanId = DB::table('account_categories')->where('name', 'Beban')->value('id');

        if (!$asetId || !$liabilitasId || !$ekuitasId || !$pendapatanId || !$bebanId) {
            $this->command->error("Pastikan semua kategori tersedia di tabel account_categories.");
            return;
        }

        // Ambil ID dari account_types berdasarkan name
        $kasBankId = DB::table('account_types')->where('name', 'Kas & Bank')->value('id');
        $piutangUsahaId = DB::table('account_types')->where('name', 'Piutang Usaha')->value('id');
        $persediaanId = DB::table('account_types')->where('name', 'Persediaan')->value('id');
        $asetTetapId = DB::table('account_types')->where('name', 'Aset Tetap')->value('id');

        $utangUsahaId = DB::table('account_types')->where('name', 'Utang Usaha')->value('id');

        $modalId = DB::table('account_types')->where('name', 'Modal')->value('id');

        $pendapatanAkunId = DB::table('account_types')->where('name', 'Pendapatan')->value('id');
        $pendapatanLainnyaId = DB::table('account_types')->where('name', 'Pendapatan Lainnya')->value('id');

        $bebanPokokId = DB::table('account_types')->where('name', 'Beban Pokok Penjualan')->value('id');
        $bebanOperasionalId = DB::table('account_types')->where('name', 'Beban')->value('id');
        $bebanLainnyaId = DB::table('account_types')->where('name', 'Beban Lainnya')->value('id');

        if (
            !$kasBankId || !$piutangUsahaId || !$persediaanId || !$asetTetapId ||
            !$utangUsahaId || !$modalId || !$pendapatanAkunId || !$pendapatanLainnyaId ||
            !$bebanPokokId || !$bebanOperasionalId || !$bebanLainnyaId
        ) {
            $this->command->error("Pastikan semua tipe akun tersedia di tabel account_types.");
            return;
        }

        $data = [
            // Aset - Kas & Bank
            [
                'name' => 'Kas',
                'description' => 'Saldo kas perusahaan',
                'normal_balance' => 'debit',
                'account_type_id' => $kasBankId,
                'account_category_id' => $asetId,
            ],
            [
                'name' => 'Bank BCA',
                'description' => 'Rekening Bank BCA',
                'normal_balance' => 'debit',
                'account_type_id' => $kasBankId,
                'account_category_id' => $asetId,
            ],

            // Aset - Piutang Usaha
            [
                'name' => 'Piutang Usaha',
                'description' => 'Piutang pelanggan',
                'normal_balance' => 'debit',
                'account_type_id' => $piutangUsahaId,
                'account_category_id' => $asetId,
            ],

            // Aset - Persediaan
            [
                'name' => 'Persediaan Ayam Mentah',
                'description' => 'Stok ayam mentah di gudang',
                'normal_balance' => 'debit',
                'account_type_id' => $persediaanId,
                'account_category_id' => $asetId,
            ],
            [
                'name' => 'Persediaan Minyak Goreng',
                'description' => 'Minyak goreng stok awal',
                'normal_balance' => 'debit',
                'account_type_id' => $persediaanId,
                'account_category_id' => $asetId,
            ],

            // Aset - Aset Tetap
            [
                'name' => 'Mobil Operasional',
                'description' => 'Mobil untuk distribusi makanan',
                'normal_balance' => 'debit',
                'account_type_id' => $asetTetapId,
                'account_category_id' => $asetId,
            ],
            [
                'name' => 'Meja & Kursi',
                'description' => 'Furniture tempat usaha',
                'normal_balance' => 'debit',
                'account_type_id' => $asetTetapId,
                'account_category_id' => $asetId,
            ],

            // Liabilitas - Utang Usaha
            [
                'name' => 'Hutang Dagang',
                'description' => 'Hutang ke supplier bahan baku',
                'normal_balance' => 'credit',
                'account_type_id' => $utangUsahaId,
                'account_category_id' => $liabilitasId,
            ],
            [
                'name' => 'Hutang Pajak',
                'description' => 'Kewajiban pajak perusahaan',
                'normal_balance' => 'credit',
                'account_type_id' => $utangUsahaId,
                'account_category_id' => $liabilitasId,
            ],

            // Ekuitas - Modal
            [
                'name' => 'Modal Dasar',
                'description' => 'Modal awal pemilik',
                'normal_balance' => 'credit',
                'account_type_id' => $modalId,
                'account_category_id' => $ekuitasId,
            ],
            [
                'name' => 'Laba Ditahan',
                'description' => 'Laba tahun lalu yang tidak dibagikan',
                'normal_balance' => 'credit',
                'account_type_id' => $modalId,
                'account_category_id' => $ekuitasId,
            ],

            // Pendapatan
            [
                'name' => 'Penjualan Ayam Goreng',
                'description' => 'Pendapatan dari penjualan ayam goreng',
                'normal_balance' => 'credit',
                'account_type_id' => $pendapatanAkunId,
                'account_category_id' => $pendapatanId,
            ],
            [
                'name' => 'Penjualan Bebek Goreng',
                'description' => 'Pendapatan dari penjualan bebek goreng',
                'normal_balance' => 'credit',
                'account_type_id' => $pendapatanAkunId,
                'account_category_id' => $pendapatanId,
            ],
            [
                'name' => 'Pendapatan Lainnya',
                'description' => 'Pendapatan non-operasional seperti jasa eksternal',
                'normal_balance' => 'credit',
                'account_type_id' => $pendapatanLainnyaId,
                'account_category_id' => $pendapatanId,
            ],

            // Beban
            [
                'name' => 'Beban Gaji',
                'description' => 'Biaya gaji karyawan',
                'normal_balance' => 'debit',
                'account_type_id' => $bebanOperasionalId,
                'account_category_id' => $bebanId,
            ],
            [
                'name' => 'Beban Listrik',
                'description' => 'Biaya listrik bulanan',
                'normal_balance' => 'debit',
                'account_type_id' => $bebanOperasionalId,
                'account_category_id' => $bebanId,
            ],
            [
                'name' => 'Beban Iklan',
                'description' => 'Biaya promosi di media sosial',
                'normal_balance' => 'debit',
                'account_type_id' => $bebanOperasionalId,
                'account_category_id' => $bebanId,
            ],
            [
                'name' => 'Beban Pengiriman',
                'description' => 'Biaya ongkir pesanan online',
                'normal_balance' => 'debit',
                'account_type_id' => $bebanLainnyaId,
                'account_category_id' => $bebanId,
            ],

            // Beban Pokok Penjualan
            [
                'name' => 'Harga Pokok Ayam',
                'description' => 'Biaya beli ayam hidup/diproses',
                'normal_balance' => 'debit',
                'account_type_id' => $bebanPokokId,
                'account_category_id' => $bebanId,
            ],
            [
                'name' => 'Harga Pokok Minyak',
                'description' => 'Biaya minyak goreng',
                'normal_balance' => 'debit',
                'account_type_id' => $bebanPokokId,
                'account_category_id' => $bebanId,
            ]
        ];

        DB::table('account_estimates')->insert($data);
    }
}
