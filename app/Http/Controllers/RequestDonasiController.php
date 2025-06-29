<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\RequestDonasi;
use Illuminate\Support\Str;

class RequestDonasiController extends Controller
{
    public function index($idOrganisasi)
    {
        $cekOrganisasi = DB::table('organisasi')->where('id_organisasi', $idOrganisasi)->exists();

        if (!$cekOrganisasi) {
            return response()->json([
                'success' => false,
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }

        $requests = DB::table('request_donasi')
            ->where('id_organisasi', $idOrganisasi)
            ->orderBy('tgl_request_donasi', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $requests
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang_request' => 'required|string|max:255',
            'tgl_request_donasi' => 'required|date',
            'id_organisasi' => 'required|string' 
        ]);

        $idOrganisasi = $request->id_organisasi;

        $cekOrganisasi = DB::table('organisasi')->where('id_organisasi', $idOrganisasi)->exists();
        if (!$cekOrganisasi) {
            return response()->json(['success' => false, 'message' => 'Organisasi tidak ditemukan.'], 404);
        }

        $lastId = DB::table('request_donasi')
            ->selectRaw("MAX(CAST(SUBSTRING(id_request_donasi, 2) AS UNSIGNED)) as max_id")
            ->value('max_id');

        $newId = 'R' . ($lastId + 1);

        DB::table('request_donasi')->insert([
            'id_request_donasi' => $newId,
            'nama_barang_request' => $request->nama_barang_request,
            'tgl_request_donasi' => $request->tgl_request_donasi,
            'id_organisasi' => $idOrganisasi,
            'status_req' => 'menunggu donasi', 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request donasi berhasil dikirim.',
            'id_request_donasi' => $newId
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang_request' => 'required|string|max:255',
        ]);

        $existing = DB::table('request_donasi')->where('id_request_donasi', $id)->first();
        if (!$existing) {
            return response()->json([
                'success' => false,
                'message' => 'Request Donasi tidak ditemukan.'
            ], 404);
        }

        DB::table('request_donasi')->where('id_request_donasi', $id)->update([
            'nama_barang_request' => $request->nama_barang_request,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request donasi berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $existing = DB::table('request_donasi')->where('id_request_donasi', $id)->first();
        if (!$existing) {
            return response()->json([
                'success' => false,
                'message' => 'Request Donasi tidak ditemukan.'
            ], 404);
        }

        DB::table('request_donasi')->where('id_request_donasi', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Request donasi berhasil dihapus.'
        ]);
    }

    public function showRequestsForOwner($idPegawai)
    {
        $pegawai = DB::table('pegawai')->where('id_pegawai', $idPegawai)->first();

        if (!$pegawai || $pegawai->id_jabatan !== 'J6') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $requests = DB::table('request_donasi')
            ->join('organisasi', 'organisasi.id_organisasi', '=', 'request_donasi.id_organisasi')
            ->select('request_donasi.*', 'organisasi.nama_organisasi')
            ->orderBy('request_donasi.tgl_request_donasi', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $requests]);
    }

    public function approveRequestDonasi(Request $request, $idPegawai, $idRequestDonasi)
    {
        $pegawai = DB::table('pegawai')->where('id_pegawai', $idPegawai)->first();
        if (!$pegawai || $pegawai->id_jabatan !== 'J6') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $request_donasi = DB::table('request_donasi')->where('id_request_donasi', $idRequestDonasi)->first();
        if (!$request_donasi) {
            return response()->json(['success' => false, 'message' => 'Request donasi tidak ditemukan.'], 404);
        }

        DB::table('request_donasi')->where('id_request_donasi', $idRequestDonasi)->update(['status_req' => 'dapat donasi']);

        DB::table('donasi')->insert([
            'id_donasi' => \Illuminate\Support\Str::uuid()->toString(),
            'id_barang' => $request->input('barang_id', null),
            'id_request_donasi' => $idRequestDonasi,
            'id_organisasi' => $request_donasi->id_organisasi,
            'tgl_donasi' => now(),
            'nama_penerima' => $request->input('nama_penerima', 'Penerima Default'),
        ]);

        return response()->json(['success' => true, 'message' => 'Request donasi berhasil disetujui dan barang didonasikan.']);
    }


    public function ownerRDonasi()
    {
        $idPegawai = session('id_pegawai');
        $pegawai = DB::table('pegawai')->where('id_pegawai', $idPegawai)->first();
        if (!$pegawai || $pegawai->id_jabatan !== 'J6') { 
            abort(403, 'Akses ditolak.');
        }

        $requests = DB::table('request_donasi')
            ->join('organisasi', 'request_donasi.id_organisasi', '=', 'organisasi.id_organisasi')
            ->select('request_donasi.*', 'organisasi.nama_organisasi')
            ->where('request_donasi.status_req', 'menunggu donasi')  
            ->orderBy('request_donasi.tgl_request_donasi', 'desc')
            ->get();

        $barangProsesDonasi = DB::table('barang')->where('status', 'barang untuk donasi')->get();

        return view('pegawai.owner.ownerRDonasi', compact('requests', 'barangProsesDonasi'));
    }

}