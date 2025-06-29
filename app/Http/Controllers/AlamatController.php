<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alamat;
use App\Models\Pembeli;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    public function index($userId)
{
    $alamat = Alamat::where('id_pembeli', $userId)->get();

    return response()->json(['data' => $alamat]);
}


    public function store(Request $request, $userId)
{
    $request->validate([
        'label_alamat' => 'required|string|max:255',
        'kecamatan' => 'required|string',
        'kabupaten' => 'required|string',
        'detail_alamat' => 'required|string',
        'desa' => 'required|string',
        'default_alamat' => 'required|boolean',
    ]);

    // Cek keberadaan pembeli
    $pembeli = Pembeli::find($userId);
    if (!$pembeli) {
        return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
    }

    // Hitung jumlah alamat yang sudah ada
    $count = Alamat::count();

    // Buat id_alamat dengan format 'A' + nomor urut
    $newIdAlamat = 'A' . ($count + 1);

    // Buat alamat baru
    $alamat = Alamat::create([
        'id_alamat' => $newIdAlamat,
        'id_pembeli' => $userId,
        'label_alamat' => $request->label_alamat,
        'kecamatan' => $request->kecamatan,
        'kabupaten' => $request->kabupaten,
        'detail_alamat' => $request->detail_alamat,
        'desa' => $request->desa,
        'default_alamat' => $request->default_alamat,
    ]);

    return response()->json(['success' => true, 'message' => 'Alamat berhasil ditambahkan', 'id_alamat' => $newIdAlamat]);
}



    // Mengupdate alamat
    public function update(Request $request, $userId, $idAlamat)
    {
        $alamat = Alamat::where('id_pembeli', $userId)->where('id_alamat', $idAlamat)->first();

        if (!$alamat) {
            return response()->json(['message' => 'Alamat tidak ditemukan'], 404);
        }

        $alamat->update($request->all());
        return response()->json(['message' => 'Alamat berhasil diperbarui']);
    }

    // Menghapus alamat
    public function destroy($userId, $idAlamat)
    {
        $alamat = Alamat::where('id_pembeli', $userId)->where('id_alamat', $idAlamat)->first();

        if (!$alamat) {
            return response()->json(['message' => 'Alamat tidak ditemukan'], 404);
        }

        $alamat->delete();
        return response()->json(['message' => 'Alamat berhasil dihapus']);
    }
}