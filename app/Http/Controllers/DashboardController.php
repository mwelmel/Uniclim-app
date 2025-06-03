<?php

namespace App\Http\Controllers;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $userName = auth()->user()->name ?? 'User';

    $barangKeluar = BarangKeluar::all();

    $totalSales = $barangKeluar->sum('jumlah');
    $salesRevenue = $barangKeluar->sum(fn($item) => $item->jumlah * $item->harga_dikonversi);
    $totalOrders = $barangKeluar->count();
    $refunded = 0; // Bisa dimodifikasi jika ada field "status" untuk return

    // Data grafik per bulan
    $monthlySales = BarangKeluar::selectRaw("strftime('%m', tanggal) as month, SUM(jumlah * harga_dikonversi) as total")
        ->groupByRaw("strftime('%m', tanggal)")
        ->pluck('total', 'month');


    $monthlyLabels = [];
    $monthlyData = [];

    foreach (range(1, 12) as $month) {
        $monthlyLabels[] = Carbon::create()->month($month)->format('F');
        $monthlyData[] = $monthlySales[$month] ?? 0;
    }

    return view('dashboard', compact(
        'userName',
        'totalSales',
        'salesRevenue',
        'totalOrders',
        'refunded',
        'monthlyLabels',
        'monthlyData'
    ));
}
}
