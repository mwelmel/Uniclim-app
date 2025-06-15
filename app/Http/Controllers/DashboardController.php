<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userName = auth()->user()->name ?? 'User';

        // Ambil semua data barang keluar
        $barangKeluar = BarangKeluar::all();

        // Hitung total penjualan
        $totalSales = $barangKeluar->sum('jumlah');

        // Hitung pendapatan
        $salesRevenue = $barangKeluar->sum(function ($item) {
            return $item->jumlah * $item->harga_dikonversi;
        });

        // Untuk refund (jika ada field status, misal: status = 'refunded')
        $refunded = 0;

        // Data grafik: total penjualan per bulan
        $monthlySales = BarangKeluar::selectRaw('MONTH(tanggal) as month, SUM(jumlah * harga_dikonversi) as total')
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->pluck('total', 'month')
            ->toArray();

        // Siapkan label bulan dan data (jan-des)
        $monthlyLabels = [];
        $monthlyData = [];

        foreach (range(1, 12) as $month) {
            $monthlyLabels[] = Carbon::create()->month($month)->locale('id')->translatedFormat('F'); 
            $monthlyData[] = isset($monthlySales[$month]) ? round($monthlySales[$month], 2) : 0;
        }

        return view('dashboard', compact(
            'userName',
            'totalSales',
            'salesRevenue',
            'refunded',
            'monthlyLabels',
            'monthlyData'
        ));
    }
}
