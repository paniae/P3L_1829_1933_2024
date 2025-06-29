<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailPemesananController extends Controller
{
    // Tampilkan semua detail pemesanan untuk pengguna saat ini
    public function index()
    {
        $userId = Auth::id();
        $detail = DetailPemesanan::where('user_id', $userId)->with('barang')->get();
        return response()->json($detail);
    }

    // Tambahkan detail pemesanan ke keranjang atau transaksi
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 400);
        }

        // Generate id_detail_pemesanan otomatis dengan prefix 'DP' dan angka incremental
        $lastId = DB::table('detail_pemesanan')
            ->selectRaw("MAX(CAST(SUBSTRING(id_detail_pemesanan, 3) AS UNSIGNED)) as max_id")
            ->value('max_id');

        $nextNumber = $lastId ? $lastId + 1 : 1;
        $newId = 'DP' . str_pad($nextNumber, 8, '0', STR_PAD_LEFT); // Contoh: DP00000001

        $detail = new DetailPemesanan();
        $detail->id_detail_pemesanan = $newId;
        $detail->user_id = Auth::id();
        $detail->barang_id = $request->barang_id;
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $barang->harga * $request->jumlah;
        $detail->save();

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang']);
    }

    // Update jumlah item dalam detail pemesanan
    public function update(Request $request, $id)
    {
        $detail = DetailPemesanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = $detail->barang;

        if ($barang->stok < $request->jumlah) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 400);
        }

        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $barang->harga * $request->jumlah;
        $detail->save();

        return response()->json(['message' => 'Jumlah berhasil diperbarui']);
    }

    // Hapus detail pemesanan (hapus dari keranjang)
    public function destroy($id)
    {
        $detail = DetailPemesanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $detail->delete();

        return response()->json(['message' => 'Item berhasil dihapus dari keranjang']);
    }
}