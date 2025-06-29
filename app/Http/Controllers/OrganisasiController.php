<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Organisasi;

class OrganisasiController extends Controller
{
    public function store(Request $request)
    {
        \Log::info("Masuk controller organisasi", $request->all());

        $request->merge([   
            'nama_organisasi' => $request->nama,
            'alamat_organisasi' => $request->alamat,
        ]);

        $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'email' => 'required|email|unique:organisasi,email',
            'password' => 'required|min:8',
            'nomor_telepon' => 'required|string|max:20',
            'alamat_organisasi' => 'required|string|max:255',
        ]);

        $idRole = DB::table('role')->where('nama_role', 'organisasi')->value('id_role');

        if (!$idRole) {
            return back()->with('error', 'Role organisasi tidak ditemukan.');
        }

        $lastId = DB::table('organisasi')
            ->selectRaw("MAX(CAST(SUBSTRING(id_organisasi, 4) AS UNSIGNED)) as max_id") // pakai 4, karena 'ORG' adalah 3 huruf
            ->value('max_id');

        $nextNumber = $lastId ? $lastId + 1 : 1; // jika null, maka mulai dari 1
        $newId = 'ORG' . $nextNumber;


        DB::table('organisasi')->insert([
            'id_organisasi' => $newId,
            'nama_organisasi' => $request->nama_organisasi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'alamat_organisasi' => $request->alamat_organisasi,
            'id_role' => $idRole,
        ]);

        return redirect()->route('login')->with('success', 'Organisasi berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $organisasi = \App\Models\Organisasi::findOrFail($id);

        $dataToUpdate = [];

        if ($request->filled('email')) {
            $dataToUpdate['email'] = $request->input('email');
        }

        if ($request->filled('nomor_telepon')) {
            $dataToUpdate['nomor_telepon'] = $request->input('nomor_telepon');
        }

        if ($request->filled('alamat_organisasi')) {
            $dataToUpdate['alamat_organisasi'] = $request->input('alamat_organisasi');
        }

        $organisasi->update($dataToUpdate);

        return response()->json(['message' => 'Data organisasi berhasil diperbarui']);
    }


    public function destroy($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        $organisasi->delete();

        return redirect()->back()->with('success', 'Organisasi berhasil dihapus.');
    }


    public function adminOrganisasi()
    {
        $organisasi = \App\Models\Organisasi::all();
        return view('pegawai.admin.adminOrganisasi', compact('organisasi'));
    }

    public function apiDetail($id)
    {
        $organisasi = DB::table('organisasi')->where('id_organisasi', $id)->first();

        if (!$organisasi) {
            return response()->json(['error' => 'Organisasi tidak ditemukan'], 404);
        }

        return response()->json([
            'id_organisasi' => $organisasi->id_organisasi,
            'nama_organisasi' => $organisasi->nama_organisasi,
            'email' => $organisasi->email,
            'nomor_telepon' => $organisasi->nomor_telepon,
        ]);
    }

}
