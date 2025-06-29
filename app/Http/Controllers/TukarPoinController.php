<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Merchandise;
use App\Models\Pembeli;
use App\Models\TukarPoin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TukarPoinController extends Controller
{
    public function tukar(Request $request)
    {
        $request->validate([
            'id_pembeli' => 'required|string',
            'id_merch' => 'required|string',
            'jml' => 'required|integer|min:1',
        ]);

        $pembeli = Pembeli::where('id_pembeli', $request->id_pembeli)->first();
        $merch = Merchandise::where('id_merch', $request->id_merch)->first();

        if (!$pembeli || !$merch) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
        }

        $jml = $request->jml;
        $hargaPoin = $merch->harga_poin ?? 0;
        $totalPoin = $hargaPoin * $jml;

        // Cek stok
        if ($merch->stok < $jml) {
            return response()->json(['success' => false, 'message' => 'Stok merchandise tidak mencukupi.'], 400);
        }

        // Cek poin pembeli
        if ($pembeli->poin < $totalPoin) {
            return response()->json(['success' => false, 'message' => 'Poin Anda tidak mencukupi.'], 400);
        }

        $lastId = DB::table('tukar_poin')
            ->whereRaw("id_tukar_poin REGEXP '^TP[0-9]+$'")
            ->selectRaw("MAX(CAST(SUBSTRING(id_tukar_poin, 3) AS UNSIGNED)) as max_id")
            ->value('max_id');

        $nextNumber = $lastId ? $lastId + 1 : 1;
        $newId = 'TP' . $nextNumber;


        // Proses penukaran
        $tukar = TukarPoin::create([
            'id_tukar_poin' => $newId,
            'id_pembeli' => $pembeli->id_pembeli,
            'id_merch' => $merch->id_merch,
            'tgl_tukar' => now(),
            'jml' => $jml,
            'status' => 'belum diambil',
        ]);

        // Update poin dan stok
        $pembeli->poin -= $totalPoin;
        $pembeli->save();

        $merch->stok -= $jml;
        $merch->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menukar poin.',
            'data' => $tukar
        ]);

        // Di controller Laravel
        try {
            // semua logic seperti biasa
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getBelumDiambil($idPembeli)
    {
        $data = DB::table('tukar_poin')
            ->join('merchandise', 'tukar_poin.id_merch', '=', 'merchandise.id_merch')
            ->where('tukar_poin.id_pembeli', $idPembeli)
            ->where('tukar_poin.status', 'belum diambil')
            ->select(
                'tukar_poin.id_tukar_poin',
                'tukar_poin.jml',
                'tukar_poin.tgl_tukar',
                'tukar_poin.status',
                'merchandise.nama_merch',
                'merchandise.gambar_merch'
            )
            ->orderBy('tukar_poin.tgl_tukar', 'desc')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'semua');

        $query = DB::table('tukar_poin')
            ->join('pembeli', 'tukar_poin.id_pembeli', '=', 'pembeli.id_pembeli')
            ->join('merchandise', 'tukar_poin.id_merch', '=', 'merchandise.id_merch')
            ->select(
                'tukar_poin.*',
                'pembeli.nama_pembeli',
                'merchandise.nama_merch'
            )
            ->orderBy('tukar_poin.tgl_tukar', 'desc');

        if ($filter != 'semua') {
            $query->where('tukar_poin.status', $filter);
        }

        $tukarPoin = $query->get();

        return view('pegawai.cs.tukar_poin', [
            'tukarPoin' => $tukarPoin,
            'filter' => $filter
        ]);
    }

    // 2. Pembeli request tukar poin (status langsung 'belum diambil')
    public function store(Request $request)
    {
        $request->validate([
            'id_pembeli' => 'required',
            'id_merch'   => 'required',
            'jml'        => 'required|integer|min:1'
        ]);

        $newId = 'TP' . time();

        DB::table('tukar_poin')->insert([
            'id_tukar_poin' => $newId,
            'id_pembeli'    => $request->id_pembeli,
            'id_merch'      => $request->id_merch,
            'tgl_tukar'     => Carbon::now(),
            'jml'           => $request->jml,
            'status'        => 'belum diambil',
        ]);

        return response()->json(['success' => true, 'message' => 'Request tukar poin dikirim, menunggu proses CS']);
    }

    // 3. CS set tanggal ambil, status tetap 'belum diambil'
    public function updateTanggalAmbil(Request $request, $id)
    {
        $request->validate([
            'tgl_ambil' => 'required|date'
        ]);

        $update = DB::table('tukar_poin')
            ->where('id_tukar_poin', $id)
            ->update([
                'tgl_ambil' => $request->tgl_ambil,
                // status tetap 'belum diambil'
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Tanggal ambil sudah diatur']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update']);
        }
    }

   public function konfirmasiAmbil($id)
    {
        $tukarPoin = DB::table('tukar_poin')->where('id_tukar_poin', $id)->first();
        if (!$tukarPoin) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $now = \Carbon\Carbon::now()->toDateString(); // Format 'Y-m-d'
        $tgl_ambil = $tukarPoin->tgl_ambil ? \Carbon\Carbon::parse($tukarPoin->tgl_ambil)->toDateString() : null;

        $updateData = ['status' => 'sudah diambil'];

        // Jika konfirmasi sebelum hari H, update tgl_ambil jadi hari ini
        if (!$tgl_ambil || $now < $tgl_ambil) {
            $updateData['tgl_ambil'] = $now;
        }

        // Update tukar poin
        $update = DB::table('tukar_poin')
            ->where('id_tukar_poin', $id)
            ->update($updateData);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Sudah diambil dan stok dikurangi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update.']);
        }
    }



}
