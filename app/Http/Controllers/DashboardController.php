<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dummy sementara
        $totalSales = 890;
        $salesRevenue = 123234000;
        $totalOrders = 567;
        $refunded = 53;

        return view('dashboard', compact('totalSales', 'salesRevenue', 'totalOrders', 'refunded'));
    }
}
