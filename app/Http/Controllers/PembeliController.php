<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pembeli;
use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use App\Models\Barang;
use App\Models\Alamat;

class PembeliController extends Controller
{
    public function store(Request $request)
    {
        \Log::info("Masuk controller pembeli", $request->all());

        $request->merge([
            'nama_pembeli' => $request->nama,
        ]);

        $request->validate([
            'nama_pembeli'   => 'required|string|max:255',
            'email'          => 'required|email|unique:pembeli',
            'password'       => 'required|min:8',
            'nomor_telepon'  => 'required|string|max:15',
            'jenis_kelamin'  => 'required|in:Pria,Wanita',
            'tgl_lahir'      => 'required|date',
        ]);

        $idRole = DB::table('role')->where('nama_role', 'pembeli')->value('id_role');

        if (!$idRole) {
            return back()->with('error', 'Role pembeli tidak ditemukan.');
        }

        $lastId = DB::table('pembeli')
            ->selectRaw("MAX(CAST(SUBSTRING(id_pembeli, 4) AS UNSIGNED)) as max_id")
            ->value('max_id');

        $nextNumber = $lastId ? $lastId + 1 : 1;
        $newId = 'PEM' . $nextNumber;

        Pembeli::create([
            'id_pembeli'     => $newId,
            'nama_pembeli'   => $request->nama_pembeli,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'nomor_telepon'  => $request->nomor_telepon,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tgl_lahir'      => $request->tgl_lahir,
            'id_role'        => $idRole,
        ]);

        return redirect()->route('login')->with('success', 'Pembeli berhasil didaftarkan.');
    }

    public function showProfile($id)
    {
        $pembeli = Pembeli::where('id_pembeli', $id)->firstOrFail();
        return view('profile.profile-pembeli', compact('pembeli'));
    }

    public function profile($id)
    {
        $pembeli = Pembeli::where('id_pembeli', $id)->firstOrFail();
        return view('pembeli.profil', compact('pembeli'));
    }

    public function getPembeliHistory($id)
    {
        $pembeli = Pembeli::where('id_pembeli', $id)->first();

        if (!$pembeli) {
            return response()->json([
                'success' => false,
                'message' => 'Pembeli tidak ditemukan.'
            ]);
        }

        $transactions = $pembeli->pemesanans()
            ->with(['detailPemesanans.barang.penitip'])
            ->get()
            ->map(function ($pemesanan) {
                $pemesanan->detailPemesanans = $pemesanan->detailPemesanans->map(function ($detail) {
                    return [
                        'id_detail' => $detail->id_detail,
                        'id_barang' => $detail->barang->id_barang ?? null,
                        'barang' => $detail->barang ?? null,
                        'rating_diberikan' => $detail->rating_diberikan,
                    ];
                });
                return $pemesanan;
            });

        return response()->json([
            'success' => true,
            'pembeli' => $pembeli,
            'data' => $transactions // jangan lupa pakai key "data" agar cocok dengan JavaScript
        ]);
    }

    public function indexAlamat($idPembeli)
    {
        $alamat = Alamat::where('id_pembeli', $idPembeli)->get();

        if ($alamat->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Alamat tidak ditemukan.']);
        }

        return response()->json(['success' => true, 'data' => $alamat]);
    }

    public function storeAlamat(Request $request, $idPembeli)
    {
        $request->validate([
            'label_alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'detail_alamat' => 'required|string',
            'desa' => 'required|string',
            'default_alamat' => 'required|boolean',
        ]);

        $alamat = new Alamat();
        $alamat->id_pembeli = $idPembeli;
        $alamat->label_alamat = $request->label_alamat;
        $alamat->kecamatan = $request->kecamatan;
        $alamat->kabupaten = $request->kabupaten;
        $alamat->detail_alamat = $request->detail_alamat;
        $alamat->desa = $request->desa;
        $alamat->default_alamat = $request->default_alamat;
        $alamat->save();

        return response()->json(['success' => true, 'message' => 'Alamat berhasil ditambahkan.']);
    }

    public function updateAlamat(Request $request, $idPembeli, $idAlamat)
    {
        $alamat = Alamat::where('id_pembeli', $idPembeli)->where('id_alamat', $idAlamat)->first();

        if (!$alamat) {
            return response()->json(['success' => false, 'message' => 'Alamat tidak ditemukan.']);
        }

        $alamat->update($request->only(['label_alamat', 'kecamatan', 'kabupaten', 'detail_alamat', 'desa', 'default_alamat']));

        return response()->json(['success' => true, 'message' => 'Alamat berhasil diperbarui.']);
    }

    public function destroyAlamat($idPembeli, $idAlamat)
    {
        $alamat = Alamat::where('id_pembeli', $idPembeli)->where('id_alamat', $idAlamat)->first();

        if (!$alamat) {
            return response()->json(['success' => false, 'message' => 'Alamat tidak ditemukan.']);
        }

        $alamat->delete();

        return response()->json(['success' => true, 'message' => 'Alamat berhasil dihapus.']);
    }

    public function showHistoryPage()
    {
        return view('pembeli.history-pembelian');
    }

    public function apiProfile($id)
    {
        $pembeli = Pembeli::where('id_pembeli', $id)->first();

        if (!$pembeli) {
            return response()->json([
                'success' => false,
                'message' => 'Data pembeli tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pembeli
        ]);
    }

    

}
