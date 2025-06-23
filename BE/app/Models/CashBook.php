<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AccountEstimate;
use App\Models\FundingSource;
use App\Models\PaymentType;
use App\Models\OrganizationalUnit;

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
        'reference'
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    // Accessor Saldo (Dinamis)
    protected $appends = ['balance'];

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

    // Scope
    public function scopeIn($query)
    {
        return $query->where('type', 'in');
    }

    public function scopeOut($query)
    {
        return $query->where('type', 'out');
    }
}
