<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemCurrencies extends Model
{
    use HasFactory;

    protected $fillable = ['currency_name', 'currency_code', 'price_rate'];
}
