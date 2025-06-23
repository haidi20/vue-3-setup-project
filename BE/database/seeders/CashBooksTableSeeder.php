<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class CashBooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil ID dari tabel master
        $accountEstimates = DB::table('account_estimates')->get(['id', 'normal_balance']);
        $fundingSourceIds = DB::table('funding_sources')->pluck('id');
        $paymentTypeIds   = DB::table('payment_types')->pluck('id');
        $unitIds          = DB::table('organizational_units')->pluck('id');

        if (
            $accountEstimates->isEmpty() || $fundingSourceIds->isEmpty() ||
            $paymentTypeIds->isEmpty() || $unitIds->isEmpty()
        ) {
            $this->command->error("Pastikan master data tersedia sebelum menjalankan seeder ini.");
            return;
        }

        // Filter hanya akun perkiraan dengan normal_balance debit (Aset)
        $cashAccounts = $accountEstimates->where('normal_balance', 'debit');

        if ($cashAccounts->isEmpty()) {
            $this->command->error("Tidak ada akun perkiraan dengan normal_balance = 'debit' (Aset).");
            return;
        }

        $accountId = $cashAccounts->random()->id;

        $data = [];
        $now = Carbon::now();

        // Pola transaksi: 1 masuk, 4 keluar, 1 masuk, 4 keluar
        $pattern = [
            'in',
            'out',
            'out',
            'out',
            'out',
            'in',
            'out',
            'out',
            'out',
            'out'
        ];

        foreach ($pattern as $i => $type) {
            $amount = rand(500000, 2000000);

            $description = $type === 'in'
                ? "Penerimaan kas dari penjualan #" . ($i + 1)
                : "Pengeluaran untuk biaya operasional #" . ($i + 1);

            $data[] = [
                'account_estimate_id'      => $accountId,
                'funding_source_id'        => $fundingSourceIds->random(),
                'payment_type_id'          => $paymentTypeIds->random(),
                'organizational_unit_id'   => $unitIds->random(),
                'transaction_date'         => $now->copy()->subDays(rand(0, 30))->format('Y-m-d'),
                'document_number'          => 'DOC-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'description'              => $description,
                'type'                     => $type,
                'amount'                   => $amount,
                'reference'                => null,
                'created_at'               => $now,
                'updated_at'               => $now,
            ];
        }

        DB::table('cash_books')->insert($data);
    }
}
