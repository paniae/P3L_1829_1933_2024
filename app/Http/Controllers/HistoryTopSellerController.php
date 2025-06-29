<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryTopSellerController extends Controller
{
    // Menampilkan barang-barang dengan penjualan terbanyak (Top Seller)
    public function index()
    {
        $topBarang = DetailPemesanan::select('barang_id', DB::raw('SUM(jumlah) as total_terjual'))
                        ->groupBy('barang_id')
                        ->orderByDesc('total_terjual')
                        ->take(10)
                        ->with('barang')
                        ->get();

        return response()->json($topBarang);
    }

    // Menampilkan riwayat barang yang telah terjual oleh penitip (user saat ini)
    public function historyByUser(Request $request)
    {
        $userId = $request->user()->id;

        $history = DetailPemesanan::whereHas('barang', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        })
                        ->with('barang')
                        ->select('barang_id', DB::raw('SUM(jumlah) as total_terjual'))
                        ->groupBy('barang_id')
                        ->orderByDesc('total_terjual')
                        ->get();

        return response()->json($history);
    }
}
