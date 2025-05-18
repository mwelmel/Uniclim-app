<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
    'total_sales',
    'sales_revenue',
    'total_orders',
    'refunded',
    'best_product',
    ];
}
