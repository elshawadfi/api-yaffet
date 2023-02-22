<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighestPrice extends Model
{
    use HasFactory;

    protected $fillable = ['metal_code', 'price', 'currency', 'price_date', 'unit'];
}
