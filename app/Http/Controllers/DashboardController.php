<?php

namespace App\Http\Controllers;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $allowedUsers = ['Chandra', 'Angelique'];

    if (!in_array($user->username, $allowedUsers)) {
        return redirect('/databarang')->with('error', 'Maaf, Anda tidak dapat mengakses halaman ini.');
    }

    $userName = $user->name ?? 'User';
    $barangKeluar = BarangKeluar::all();

    $totalSales = $barangKeluar->sum('jumlah');
    $salesRevenue = $barangKeluar->sum(fn($item) => $item->jumlah * $item->harga_dikonversi);
    $totalOrders = $barangKeluar->count();
    $refunded = 0;

    $monthlySales = BarangKeluar::selectRaw("MONTH(tanggal) as month, SUM(jumlah * harga_dikonversi) as total")
        ->groupByRaw("MONTH(tanggal)")
        ->orderByRaw("MONTH(tanggal)")
        ->pluck('total', 'month');

    $monthlyLabels = [];
    $monthlyData = [];

    foreach (range(1, 12) as $month) {
        $monthlyLabels[] = \Carbon\Carbon::create()->month($month)->format('F');
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
