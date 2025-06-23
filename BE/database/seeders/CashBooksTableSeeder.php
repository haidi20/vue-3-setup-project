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
        $accountEstimates = AccountEstimate::all(['id', 'normal_balance', 'name']);
        $unitIds = OrganizationalUnit::pluck('id');

        // Ambil ID = 1 untuk funding_source dan payment_type
        $fundingSourceId = FundingSource::where('id', 1)->value('id');
        $paymentTypeId = PaymentType::where('id', 1)->value('id');

        if (
            $accountEstimates->isEmpty() || is_null($fundingSourceId) || is_null($paymentTypeId) || $unitIds->isEmpty()
        ) {
            $this->command->error("Pastikan master data tersedia, termasuk record dengan id = 1 di funding_sources dan payment_types.");
            return;
        }

        $now = Carbon::now();
        $data = [];

        foreach ($accountEstimates as $account) {
            $accountId = $account->id;
            $accountName = $account->name;

            for ($i = 0; $i < 5; $i++) {
                $transactionNumber = $i + 1;
                $type = match ($account->normal_balance) {
                    'debit' => $i === 0 ? 'in' : 'out',
                    'credit' => $i === 0 ? 'out' : 'in',
                    default => 'out'
                };

                $amount = rand(50000, 2000000);
                $description = match ($type) {
                    'in' => "Penerimaan kas dari {$accountName} #{$transactionNumber}",
                    'out' => "Pengeluaran untuk {$accountName} #{$transactionNumber}",
                    default => "Transaksi tidak diketahui untuk Akun ID: {$accountId}"
                };

                $data[] = [
                    'account_estimate_id' => $accountId,
                    'funding_source_id' => $fundingSourceId, // Selalu pakai id = 1
                    'payment_type_id' => $paymentTypeId,     // Selalu pakai id = 1
                    'organizational_unit_id' => $unitIds->random(),
                    'transaction_date' => $now->copy()->subDays(rand(0, 30))->format('Y-m-d'),
                    'document_number' => 'DOC-' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
                    'description' => $description,
                    'type' => $type,
                    'amount' => $amount,
                    'reference' => null,
                    'created_by' => 1, // Asumsi user ID 1
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        CashBook::insert($data);
    }
}
