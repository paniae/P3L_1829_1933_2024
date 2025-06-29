<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiskusiProduk;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use Illuminate\Support\Facades\Session;

class DiskusiProdukController extends Controller
{
    public function index()
    {
        $barang = Barang::with(['diskusi_produks' => function($q) {
            $q->orderBy('tgl_komentar', 'desc')->limit(1);
        }])
        ->where('status', 'tersedia')
        ->get();

        foreach ($barang as $item) {
            $item->latestKomentar = $item->diskusi_produks->first() ?? null;
        }

        return view('pegawai.cs.diskusi_produk_cs', compact('barang'));
    }

    /**
     * Simpan komentar baru, bisa dari pembeli atau pegawai (CS)
     */
    public function store(Request $request)
{
    $request->validate([
        'id_barang' => 'required|exists:barang,id_barang',
        'komentar' => 'required|string|max:1000',
    ]);

    $id_pegawai = session('id_pegawai');
    $id_pembeli = session('id_pembeli');

    if ($id_pembeli) {
        // User adalah pembeli
        $userType = 'pembeli';
        $userId = $id_pembeli;
    } elseif ($id_pegawai) {
        // User adalah pegawai CS
        $userType = 'pegawai';
        $userId = $id_pegawai;
    } else {
        return response()->json([
            'success' => false,
            'message' => 'User tidak terautentikasi.'
        ]);
    }

    // Batasi maksimal 10 komentar per barang
    $jumlah = DiskusiProduk::where('id_barang', $request->id_barang)->count();
    if ($jumlah >= 10) {
        DiskusiProduk::where('id_barang', $request->id_barang)
            ->orderBy('tgl_komentar', 'asc')
            ->first()
            ->delete();
    }

    // Generate id_diskusi baru
    $last = DiskusiProduk::orderByRaw("CAST(SUBSTRING(id_diskusi, 2) AS UNSIGNED) DESC")->first();
    $newId = $last ? 'd' . (intval(substr($last->id_diskusi, 1)) + 1) : 'd1';

    $diskusi = new DiskusiProduk();
    $diskusi->id_diskusi = $newId;
    $diskusi->id_barang = $request->id_barang;
    $diskusi->komentar = $request->komentar;
    $diskusi->tgl_komentar = now();

    if ($userType === 'pembeli') {
        $diskusi->id_pembeli = $userId;
        $diskusi->id_pegawai = null;
    } else {
        $diskusi->id_pegawai = $userId;
        $diskusi->id_pembeli = null;
    }

    $diskusi->save();

    return response()->json([
        'success' => true,
        'nama' => $userType === 'pembeli' ? $diskusi->pembeli->nama_pembeli : $diskusi->pegawai->nama_pegawai,
        'komentar' => $diskusi->komentar,
        'tgl_komentar' => $diskusi->tgl_komentar,
        'isCS' => $userType === 'pegawai',
    ]);
    }
    /**
     * Ambil semua komentar untuk suatu barang
     */
    public function getByBarang($id_barang)
    {
        $komentar = DiskusiProduk::with(['pembeli', 'pegawai'])
            ->where('id_barang', $id_barang)
            ->orderBy('tgl_komentar', 'asc') // supaya komentar lama atas, baru bawah
            ->get();

        return response()->json($komentar);
    }

    /**
     * Hapus komentar, hanya boleh dihapus oleh yang punya komentar
     */
    public function destroy(Request $request, $id_diskusi)
    {
        $komentar = DiskusiProduk::find($id_diskusi);

        if (!$komentar) {
            return response()->json(['message' => 'Komentar tidak ditemukan.'], 404);
        }

        // Ambil user dari session (bisa disesuaikan jika menggunakan Auth)
        $id_pembeli = Session::get('id_pembeli');
        $id_pegawai = Session::get('id_pegawai');

        // Cek hak hapus: hanya pembuat komentar (pembeli atau pegawai) yang bisa hapus
        if (
            ($komentar->id_pembeli && $komentar->id_pembeli !== $id_pembeli) &&
            ($komentar->id_pegawai && $komentar->id_pegawai !== $id_pegawai)
        ) {
            return response()->json(['message' => 'Anda tidak berhak menghapus komentar ini.'], 403);
        }

        $komentar->delete();

        return response()->json(['message' => 'Komentar berhasil dihapus.']);
    }
}
