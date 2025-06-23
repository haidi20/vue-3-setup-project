<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountCategory;
use App\Models\AccountType;
use App\Models\AccountEstimate;
use App\Models\AccountingPeriod;
use App\Models\BankAccount;
use App\Models\FundingSource;
use App\Models\TransactionType;
use App\Models\PaymentType;
use App\Models\OrganizationalUnit;
use App\Models\CashBook;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCounts = [
            ['label' => 'Kategori Akun', 'value' => AccountCategory::count()],
            ['label' => 'Tipe Akun', 'value' => AccountType::count()],
            ['label' => 'Estimasi Akun', 'value' => AccountEstimate::count()],
            ['label' => 'Periode Akuntansi', 'value' => AccountingPeriod::count()],
            ['label' => 'Rekening Bank', 'value' => BankAccount::count()],
            ['label' => 'Sumber Dana', 'value' => FundingSource::count()],
            ['label' => 'Tipe Transaksi', 'value' => TransactionType::count()],
            ['label' => 'Tipe Pembayaran', 'value' => PaymentType::count()],
            ['label' => 'Unit Organisasi', 'value' => OrganizationalUnit::count()],
            ['label' => 'Pembukuan Kas', 'value' => CashBook::count()],
        ];

        return view('dashboard.index', compact('dataCounts'));
    }
}
