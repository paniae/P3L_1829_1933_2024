<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RequestDonasi;
use App\Models\Donasi;
use Illuminate\Support\Str; 

class DonasiController extends Controller
{
    public function index()
    {
        $organisasi = DB::table('organisasi')->get();  
        return view('nama_view', compact('organisasi')); 
    }

    public function donasi(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'nama_penerima' => 'required|string|max:255',
        ]);

        $requestDonasi = RequestDonasi::findOrFail($id);

        $id_barang = $request->id_barang;

        $barang = DB::table('barang')->where('id_barang', $id_barang)->first();

        if (!$barang) {
            return back()->withErrors(['id_barang' => 'Barang tidak ditemukan']);
        }

        $id_penitip = $barang->id_penitip;
        $harga_barang = $barang->harga_barang;

        $poin = floor($harga_barang / 10000);

        $newIdDonasi = 'DO' . (Donasi::max(DB::raw('CAST(SUBSTRING(id_donasi, 3) AS UNSIGNED)')) + 1 ?? 1);

        Donasi::create([
            'id_donasi' => $newIdDonasi,
            'id_barang' => $id_barang,
            'id_request_donasi' => $requestDonasi->id_request_donasi,
            'id_organisasi' => $requestDonasi->id_organisasi,
            'tgl_donasi' => now(),
            'nama_penerima' => $request->nama_penerima,
        ]);

        DB::table('request_donasi')
            ->where('id_request_donasi', $requestDonasi->id_request_donasi)
            ->update(['status_req' => 'dapat donasi']);

        DB::table('barang')
            ->where('id_barang', $id_barang)
            ->update(['status' => 'didonasikan']);

        DB::table('penitip')
            ->where('id_penitip', $id_penitip)
            ->increment('poin', $poin);

        return redirect()->route('owner.requestRDonasi')->with('success', "Donasi berhasil dilakukan. Poin yang diterima penitip: $poin");
    }


    public function ownerHistoryDonasi()
    {
        $organisasiIds = DB::table('donasi')
            ->distinct()
            ->pluck('id_organisasi');

        $organisasi = DB::table('organisasi')
            ->whereIn('id_organisasi', $organisasiIds)
            ->get();

        return view('pegawai.owner.ownerHistoryDonasi', compact('organisasi'));
    }

    public function donasiByOrganisasi($idOrganisasi)
    {
        $donasi = DB::table('donasi')
            ->join('request_donasi', 'donasi.id_request_donasi', '=', 'request_donasi.id_request_donasi')
            ->where('donasi.id_organisasi', $idOrganisasi)
            ->select('donasi.id_donasi', 'request_donasi.nama_barang_request', 'donasi.tgl_donasi', 'donasi.nama_penerima')
            ->orderBy('donasi.tgl_donasi', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $donasi]);
    }


}