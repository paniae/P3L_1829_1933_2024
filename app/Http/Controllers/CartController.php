<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembeli;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        $idsBarang = array_keys($cartItems);

        // Ambil status terbaru barang dari DB
        $statusBarang = Barang::whereIn('id_barang', $idsBarang)->pluck('status', 'id_barang')->toArray();

        // Update status di cartItems sesuai status DB
        foreach ($cartItems as $idBarang => &$item) {
            $item['status'] = $statusBarang[$idBarang] ?? 'tidak tersedia';
        }
        unset($item);

        // Simpan ulang cart dengan status terbaru di session
        session(['cart' => $cartItems]);

        // Cek apakah ada barang terjual
        $adaBarangTerjual = collect($cartItems)->contains(fn($item) => $item['status'] === 'terjual');

        $idPembeli = session('id_pembeli');
        $pembeli = Pembeli::where('id_pembeli', $idPembeli)->first();

        return view('pembeli.cart', compact('cartItems', 'pembeli', 'adaBarangTerjual'));
    }
    public function addToCart($id)
    {
        $barang = Barang::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            return redirect()->back()->with('cart_success', 'Barang sudah ada di keranjang!');
        }

        $cart[$id] = [
            "nama_barang" => $barang->nama_barang,
            "harga_barang" => $barang->harga_barang,
            "foto_barang" => $barang->foto_barang,
            "quantity" => 1,
            "status" => $barang->status // simpan status barang di cart
        ];

        session()->put('cart', $cart);

        // Jangan ubah status barang di sini supaya tetap muncul di cart pembeli lain

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan di keranjang.');
        }

        unset($cart[$id]);
        session()->put('cart', $cart);

        // Update status barang kembali ke 'tersedia'
        $barang = Barang::find($id);
        if ($barang) {
            $barang->status = 'tersedia';
            $barang->save();
        }

        return redirect()->back()->with('success', 'Barang dihapus dari keranjang!');
    }
}