<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MerchandiseController extends Controller
{
    public function adminMerchandise()
    {
        $merchandise = Merchandise::all();
        return view('pegawai.admin.adminMerchandise', compact('merchandise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merch'  => 'required|string',
            'stok'        => 'required|integer',
            'harga_poin'  => 'required|integer',
            'gambar_merch'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $lastId = DB::table('merchandise')
            ->selectRaw("MAX(CAST(SUBSTRING(id_merch, 2) AS UNSIGNED)) as max_id")
            ->value('max_id');
        $newId = 'M' . ($lastId + 1);
        $idPegawai = session('id_pegawai');

        // Upload gambar
        $fileName = null;
        if ($request->hasFile('gambar_merch')) {
            $file = $request->file('gambar_merch');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/merchandise'), $fileName);
        }

        Merchandise::create([
            'id_merch'     => $newId,
            'id_pegawai'   => $idPegawai,
            'nama_merch'   => $request->nama_merch,
            'stok'         => $request->stok,
            'harga_poin'   => $request->harga_poin,
            'gambar_merch' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Merchandise berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $merch = Merchandise::findOrFail($id);

        $request->validate([
            'nama_merch'    => 'required|string|max:255',
            'stok'          => 'required|integer|min:0',
            'harga_poin'    => 'required|integer|min:0',
            'gambar_merch'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_merch'  => $request->nama_merch,
            'stok'        => $request->stok,
            'harga_poin'  => $request->harga_poin,
            'id_pegawai'  => session('id_pegawai'),
        ];

        if ($request->hasFile('gambar_merch')) {
            // Optional: delete old image if needed
            if ($merch->gambar_merch && file_exists(public_path('storage/merchandise/' . $merch->gambar_merch))) {
                unlink(public_path('storage/merchandise/' . $merch->gambar_merch));
            }

            $file = $request->file('gambar_merch');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/merchandise'), $fileName);

            $data['gambar_merch'] = $fileName;
        }

        $merch->update($data);

        return response()->json(['message' => 'Data merchandise berhasil diubah.']);
    }

    public function destroy($id)
    {
        $merch = Merchandise::findOrFail($id);

        if ($merch->gambar_merch && file_exists(public_path('storage/merchandise/' . $merch->gambar_merch))) {
            unlink(public_path('storage/merchandise/' . $merch->gambar_merch));
        }

        $merch->delete();
        return redirect()->back()->with('success', 'Merchandise berhasil dihapus.');
    }

    public function showAllMerchandise()
    {
        $merchandise = Merchandise::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar merchandise berhasil diambil.',
            'data' => $merchandise
        ]);
    }
}
