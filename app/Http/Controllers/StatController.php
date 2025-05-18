<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function latest()
    {
        $latest = Stat::latest()->first();
        return response()->json($latest);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'total_sales' => 'required|integer',
            'sales_revenue' => 'required|integer',
            'total_orders' => 'required|integer',
            'refunded' => 'required|integer',
            'best_product' => 'nullable|string',
        ]);

        $stat = Stat::create($data);
        return response()->json($stat, 201);
    }
}
