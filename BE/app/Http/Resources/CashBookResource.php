<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashBookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transaction_date' => $this->transaction_date,
            'transaction_date_readable' => $this->transaction_date_readable,
            'document_number' => $this->document_number,
            'description' => $this->description,
            'type' => $this->type,
            'debit' => $this->debit,
            'debit_readable' => $this->debit_readable,
            'credit' => $this->credit,
            'credit_readable' => $this->credit_readable,
            'balance' => $this->balance,
            'balance_readable' => $this->balance_readable,
            'reference' => $this->reference,
            'account_estimate_name' => $this->account_estimate_name,
            'funding_source_name' => $this->funding_source_name,
            'payment_type_name' => $this->payment_type_name,
            'organizational_unit_name' => $this->organizational_unit_name,
        ];
    }
}
