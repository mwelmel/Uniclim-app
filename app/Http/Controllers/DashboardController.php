<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data from the database or any other source
        $userName = 'John Doe'; // Example user name
        $totalSales = 1000; // Example total sales
        $salesRevenue = 50000; // Example sales revenue
        $totalOrders = 200; // Example total orders
        $refunded = 50; // Example refunded amount

        return view('dashboard', [
            'userName' => $userName,
            'totalSales' => $totalSales,
            'salesRevenue' => $salesRevenue,
            'totalOrders' => $totalOrders,
            'refunded' => $refunded,
        ]);
    }
}
