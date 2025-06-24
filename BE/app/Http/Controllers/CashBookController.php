<?php

namespace App\Http\Controllers;

use App\Models\CashBook;
use Illuminate\Http\Request;

class CashBookController extends Controller
{
    /**
     * Display a listing of the cash book entries.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Ambil data dengan pagination
        $cashBooks = CashBook::with([
            'accountEstimate',
            'fundingSource',
            'paymentType',
            'organizationalUnit'
        ])->orderBy('transaction_date', 'asc')->paginate(5);

        // Kirim ke Vue via Inertia
        return inertia('CashBook', [
            'data' => $cashBooks
        ]);
    }
}
