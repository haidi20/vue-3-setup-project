<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashBookResource;
use App\Models\CashBook;
use Inertia\Inertia;

class CashBookController extends Controller
{
    /**
     * Display a listing of the cash book entries.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $cashBooks = CashBook::with([
            'accountEstimate',
            'fundingSource',
            'paymentType',
            'organizationalUnit'
        ])
            ->orderBy('transaction_date', 'asc')
            ->paginate(5);

        return Inertia::render('CashBook', [
            'cash_books' => CashBookResource::collection($cashBooks),
        ]);
    }
}
