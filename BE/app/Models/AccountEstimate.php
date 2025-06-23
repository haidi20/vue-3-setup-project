<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountEstimate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'account_estimates';
    protected $guarded = [];

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class);
    }
}
