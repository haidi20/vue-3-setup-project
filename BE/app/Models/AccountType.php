<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'account_types';
    protected $guarded = [];

    // Define relationships or methods as needed
}
