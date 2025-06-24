<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\CashBook;
use App\Models\AccountEstimate;
use App\Models\FundingSource;
use App\Models\PaymentType;
use App\Models\OrganizationalUnit;

class CashBooksTableSeeder extends Seeder
{
    public function run()
    {
        // Ambil data master dengan Eloquent
        $unitId = OrganizationalUnit::value('id');
        if (!$unitId) {
            $this->command->error("Pastikan ada data di tabel organizational_units.");
            return;
        }

        $fundingSourceId = FundingSource::where('id', 1)->value('id');
        $paymentTypeId = PaymentType::where('id', 1)->value('id');

        if (!$fundingSourceId || !$paymentTypeId) {
            $this->command->error("Pastikan record dengan id = 1 tersedia di funding_sources dan payment_types.");
            return;
        }

        // Ambil ID akun yang relevan dari AccountEstimate
        $accountIds = AccountEstimate::whereIn('name', [
            'Modal Dasar',
            'Persediaan Ayam Mentah',
            'Persediaan Minyak Goreng',
            'Penjualan Ayam Goreng'
        ])->pluck('id', 'name');

        if ($accountIds->count() < 4) {
            $this->command->error("Beberapa akun penting tidak ditemukan di account_estimates.");
            return;
        }

        // Waktu dasar
        $startDate = Carbon::create(2025, 5, 1); // 1 Mei 2025
        $endDate = Carbon::create(2025, 5, 31); // 31 Mei 2025
        $now = Carbon::now();

        $data = [];

        // 1. Modal Awal
        $data[] = [
            'account_estimate_id' => $accountIds['Modal Dasar'],
            'funding_source_id' => $fundingSourceId,
            'payment_type_id' => $paymentTypeId,
            'organizational_unit_id' => $unitId,
            'transaction_date' => $startDate->copy()->format('Y-m-d'),
            'document_number' => 'DOC-001',
            'description' => 'Setoran modal awal pemilik',
            'type' => 'in',
            'amount' => 15000000,
            'reference' => null,
            'created_by' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // 2. Pembelian Ayam (3x dalam bulan)
        $purchasesAyam = [
            ['date' => '2025-05-03', 'amount' => 3000000],
            ['date' => '2025-05-10', 'amount' => 3500000],
            ['date' => '2025-05-17', 'amount' => 4000000],
        ];

        foreach ($purchasesAyam as $index => $purchase) {
            $data[] = [
                'account_estimate_id' => $accountIds['Persediaan Ayam Mentah'],
                'funding_source_id' => $fundingSourceId,
                'payment_type_id' => $paymentTypeId,
                'organizational_unit_id' => $unitId,
                'transaction_date' => $purchase['date'],
                'document_number' => 'DOC-' . str_pad(2 + $index, 3, '0', STR_PAD_LEFT),
                'description' => "Pembelian ayam hidup dari supplier",
                'type' => 'out',
                'amount' => $purchase['amount'],
                'reference' => null,
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 3. Pembelian Minyak Goreng (2x dalam bulan)
        $purchasesMinyak = [
            ['date' => '2025-05-05', 'amount' => 500000],
            ['date' => '2025-05-20', 'amount' => 600000],
        ];

        foreach ($purchasesMinyak as $index => $purchase) {
            $data[] = [
                'account_estimate_id' => $accountIds['Persediaan Minyak Goreng'],
                'funding_source_id' => $fundingSourceId,
                'payment_type_id' => $paymentTypeId,
                'organizational_unit_id' => $unitId,
                'transaction_date' => $purchase['date'],
                'document_number' => 'DOC-' . str_pad(4 + $index, 3, '0', STR_PAD_LEFT),
                'description' => "Pembelian minyak goreng",
                'type' => 'out',
                'amount' => $purchase['amount'],
                'reference' => null,
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 4. Penjualan Harian (setiap hari mulai 5 Mei s.d. 30 Mei)
        for ($day = 5; $day <= 30; $day++) {
            $tanggal = $startDate->copy()->day($day);

            // Cek apakah weekend (Sabtu/Minggu)
            $isWeekend = in_array($tanggal->format('l'), ['Saturday', 'Sunday']);

            // Omset harian realistis untuk UMKM
            if ($isWeekend) {
                $jumlahPenjualan = rand(300000, 450000); // Weekend lebih ramai
            } else {
                $jumlahPenjualan = rand(80000, 300000); // Hari biasa
            }

            $data[] = [
                'account_estimate_id' => $accountIds['Penjualan Ayam Goreng'],
                'funding_source_id' => $fundingSourceId,
                'payment_type_id' => $paymentTypeId,
                'organizational_unit_id' => $unitId,
                'transaction_date' => $tanggal->format('Y-m-d'),
                'document_number' => 'INV-' . str_pad($day - 4, 3, '0', STR_PAD_LEFT),
                'description' => "Penjualan ayam goreng harian - {$tanggal->format('d M Y')}",
                'type' => 'in',
                'amount' => $jumlahPenjualan,
                'reference' => null,
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Hapus data lama
        CashBook::truncate();

        // Masukkan data baru
        foreach ($data as $item) {
            CashBook::create($item);
        }
    }
}
