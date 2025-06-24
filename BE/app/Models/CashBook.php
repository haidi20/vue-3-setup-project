<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cash_books';

    protected $fillable = [
        'account_estimate_id',
        'funding_source_id',
        'payment_type_id',
        'organizational_unit_id',
        'transaction_date',
        'document_number',
        'description',
        'type',
        'amount',
        'status',
        'reference',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    protected $appends = [
        'balance',
        'transaction_date_readable',
        'account_estimate_name',
        'funding_source_name',
        'payment_type_name',
        'organizational_unit_name',
        'debit',
        'credit',
        'created_at_readable',
        'transaction_date_readable',
        'debit_readable',
        'credit_readable',
        'balance_readable',
    ];

    // Relasi tetap sama
    public function accountEstimate()
    {
        return $this->belongsTo(AccountEstimate::class);
    }

    public function fundingSource()
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    // Accessor lainnya juga tetap sama...

    public function getAccountEstimateNameAttribute()
    {
        return $this->accountEstimate->name ?? '-';
    }

    public function getFundingSourceNameAttribute()
    {
        return $this->fundingSource->name ?? '-';
    }

    public function getPaymentTypeNameAttribute()
    {
        return $this->paymentType->name ?? '-';
    }

    public function getOrganizationalUnitNameAttribute()
    {
        return $this->organizationalUnit->name ?? '-';
    }

    public function getDebitAttribute()
    {
        return $this->type === 'in' ? $this->amount : 0;
    }

    public function getCreditAttribute()
    {
        return $this->type === 'out' ? $this->amount : 0;
    }

    public function getBalanceAttribute()
    {
        $prevTransactions = self::where('id', '<', $this->id)->orderBy('id')->get();
        $saldo = 0;

        foreach ($prevTransactions as $t) {
            $saldo += ($t->type === 'in') ? $t->amount : -$t->amount;
        }

        $saldo += ($this->type === 'in') ? $this->amount : -$this->amount;

        return $saldo;
    }

    public function getCreatedAtReadableAttribute()
    {
        return $this->created_at ? $this->created_at->translatedFormat('l, d F Y') : '';
    }

    public function getTransactionDateReadableAttribute()
    {
        return $this->transaction_date ? $this->transaction_date->translatedFormat('l, d F Y') : '';
    }

    public function getDebitReadableAttribute()
    {
        return $this->debit ? number_format($this->debit, 0, ',', '.') : '';
    }

    public function getCreditReadableAttribute()
    {
        return $this->credit ? number_format($this->credit, 0, ',', '.') : '';
    }

    public function getBalanceReadableAttribute()
    {
        return $this->balance ? number_format($this->balance, 0, ',', '.') : '';
    }
}
