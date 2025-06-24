<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\AccountEstimate;
use App\Models\FundingSource;
use App\Models\PaymentType;
use App\Models\OrganizationalUnit;
use App\Models\CashBook;

class CashBooksTableSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua master data
        $accountEstimates = AccountEstimate::all(['id', 'normal_balance', 'name']);
        $unitIds = OrganizationalUnit::pluck('id');

        // Gunakan ID tetap untuk Funding Source dan Payment Type
        $fundingSourceId = FundingSource::where('id', 1)->value('id');
        $paymentTypeId = PaymentType::where('id', 1)->value('id');

        // Validasi jika data master tidak tersedia
        if ($accountEstimates->isEmpty() || is_null($fundingSourceId) || is_null($paymentTypeId) || $unitIds->isEmpty()) {
            $this->command->error("Pastikan semua master data tersedia, termasuk record dengan id = 1 di funding_sources dan payment_types.");
            return;
        }

        // Waktu saat ini
        $now = Carbon::now();
        $data = [];

        foreach ($accountEstimates as $account) {
            $accountId = $account->id;
            $accountName = $account->name;

            // Tambahkan SALDO AWAL sebagai transaksi pertama
            $initialAmount = rand(500000, 5000000); // Saldo awal acak
            $data[] = [
                'account_estimate_id' => $accountId,
                'funding_source_id' => $fundingSourceId,
                'payment_type_id' => $paymentTypeId,
                'organizational_unit_id' => $unitIds->random(),
                'transaction_date' => $now->copy()->subDays(31)->format('Y-m-d'), // Lebih awal dari transaksi lain
                'document_number' => "INIT-{$accountId}",
                'description' => "Saldo Awal - {$accountName}",
                'type' => 'in',
                'amount' => $initialAmount,
                'reference' => null,
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Tambahkan 5 transaksi biasa
            for ($i = 1; $i <= 5; $i++) {
                $type = match ($account->normal_balance) {
                    'debit' => $i % 2 === 0 ? 'out' : 'in',
                    'credit' => $i % 2 === 0 ? 'in' : 'out',
                    default => 'out'
                };

                $amount = rand(50000, 2000000);

                $description = match ($type) {
                    'in' => "Penerimaan kas dari {$accountName} #{$i}",
                    'out' => "Pengeluaran untuk {$accountName} #{$i}",
                    default => "Transaksi tidak diketahui untuk Akun ID: {$accountId}"
                };

                $randomDaysAgo = rand(1, 30); // Acak antara 1–30 hari lalu
                $transactionDate = $now->copy()->subDays($randomDaysAgo)->format('Y-m-d');

                $data[] = [
                    'account_estimate_id' => $accountId,
                    'funding_source_id' => $fundingSourceId,
                    'payment_type_id' => $paymentTypeId,
                    'organizational_unit_id' => $unitIds->random(),
                    'transaction_date' => $transactionDate,
                    'document_number' => 'DOC-' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
                    'description' => $description,
                    'type' => $type,
                    'amount' => $amount,
                    'reference' => null,
                    'created_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Urutkan data berdasarkan tanggal agar perhitungan saldo benar
        usort($data, function ($a, $b) {
            return strtotime($a['transaction_date']) - strtotime($b['transaction_date']);
        });

        // Hapus data lama (opsional)
        CashBook::truncate();

        // Insert data baru
        CashBook::insert($data);
    }
}
