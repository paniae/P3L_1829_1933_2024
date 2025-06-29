<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KlaimMerchandiseController extends Controller
{
    // Tampilkan halaman daftar klaim
    public function index(Request $request)
    {
        // === DEBUG: Cek apakah user sudah login atau belum ===
        $filter = $request->get('filter', 'semua');
        
        // Join dengan pembeli, merchandise, pegawai (CS)
        $query = DB::table('klaim_merchandise')
            ->join('pembeli', 'klaim_merchandise.id_pembeli', '=', 'pembeli.id_pembeli')
            ->join('merchandise', 'klaim_merchandise.id_merch', '=', 'merchandise.id_merch')
            ->join('pegawai as cs', 'klaim_merchandise.id_pegawai', '=', 'cs.id_pegawai')
            ->select(
                'klaim_merchandise.*',
                'pembeli.nama_pembeli',
                'merchandise.nama_merch',
                'cs.nama_pegawai as nama_cs'
            )
            ->orderBy('klaim_merchandise.created_at', 'desc');

        if ($filter == 'belum') {
            $query->where('klaim_merchandise.status_ambil', 'belum');
        }

        $klaim = $query->get();

        return view('pegawai.cs.klaim_merchandise', [
            'klaim' => $klaim,
        ]);
    }


    // Update tanggal ambil
    public function updateTanggalAmbil(Request $request, $id)
    {
        $request->validate([
            'tanggal_ambil' => 'required|date'
        ]);

        $update = DB::table('klaim_merchandise')
            ->where('id_klaim', $id)
            ->update([
                'tanggal_ambil' => $request->tanggal_ambil,
                'status_ambil' => 'sudah',
                'updated_at' => Carbon::now()
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Tanggal ambil diupdate']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update']);
        }
    }
}