<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'account_categories';
    protected $guarded = [];

    // Define relationships or methods as needed
}
