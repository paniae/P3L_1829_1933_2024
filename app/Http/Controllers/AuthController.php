<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string',
            'tgl_lahir' => 'nullable|date',
        ]);

        $role = $validated['role'];

        switch ($role) {
            case 'pembeli':
                $newId = 'PB' . (DB::table('pembeli')->count() + 1);
                DB::table('pembeli')->insert([
                    'id_pembeli' => $newId,
                    'nama_pembeli' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'nomor_telepon' => $validated['nomor_telepon'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'tanggal_lahir' => $validated['tgl_lahir'],
                ]);
                break;

            case 'organisasi':
                $newId = 'ORG' . (DB::table('organisasi')->count() + 1);
                DB::table('organisasi')->insert([
                    'id_organisasi' => $newId,
                    'nama_organisasi' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'nomor_telepon' => $validated['nomor_telepon'],
                    'alamat_organisasi' => $validated['alamat'],
                ]);
                break;
        }

        return redirect()->route('register')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
{
    $tables = [
        'penitip' => ['table' => 'penitip', 'id_col' => 'id_penitip', 'name_col' => 'nama_penitip'],
        'pembeli' => ['table' => 'pembeli', 'id_col' => 'id_pembeli', 'name_col' => 'nama_pembeli'],
        'organisasi' => ['table' => 'organisasi', 'id_col' => 'id_organisasi', 'name_col' => 'nama_organisasi'],
        'pegawai' => ['table' => 'pegawai', 'id_col' => 'id_pegawai', 'name_col' => 'nama_pegawai'],
    ];

    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    foreach ($tables as $role => $info) {
    $user = DB::table($info['table'])->where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        $redirect = match ($role) {
            'pembeli' => '/home-beli',
            'penitip' => '/penitip/barang-titipan',
            'organisasi' => '/organisasi/index_organisasi',
            'pegawai' => '/pegawai/home',
            default => '/',
        };

        $jabatan = null;
        if ($role === 'pegawai') {
            $jabatan = DB::table('jabatan')->where('id_jabatan', $user->id_jabatan)->value('nama_jabatan');
            $redirect = match ($jabatan) {
                'Admin' => '/pegawai/admin',
                'Customer Service' => '/pegawai/cs',
                'Owner' => '/pegawai/ownerRDonasi',
                default => '/pegawai/home',
            };
        }

        // Simpan session sesuai role, hapus session lain supaya tidak bentrok
        if ($role === 'pegawai') {
            Session::put('id_pegawai', $user->{$info['id_col']});
            Session::forget('id_pembeli');
        } elseif ($role === 'pembeli') {
            Session::put('id_pembeli', $user->{$info['id_col']});
            Session::forget('id_pegawai');
        } else {
            Session::forget('id_pegawai');
            Session::forget('id_pembeli');
        }

        Session::put([
            'role' => $role,
            'nama' => $user->{$info['name_col']},
            'user_id' => $user->{$info['id_col']},
            $info['id_col'] => $user->{$info['id_col']},
            'jabatan' => $jabatan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'role' => $role,
            'nama' => $user->{$info['name_col']},
            'redirect' => $redirect,
            'jabatan' => $jabatan,
            'id_user' => $user->{$info['id_col']},
            'id_pembeli' => $role === 'pembeli' ? $user->{$info['id_col']} : null
        ]);
    }
}


    // ❗ INI HARUS JSON!
    return response()->json([
        'success' => false,
        'message' => 'Email atau password salah.'
    ], 401);
}


    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $email = $request->input('email');

    // Cek apakah email ada di salah satu tabel pengguna
    $user = DB::table('pembeli')->where('email', $email)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak ditemukan.'
        ]);
    }

    // TODO: Kirim email reset password di sini
    // Untuk saat ini cukup simulasi:
    return response()->json([
        'success' => true,
        'message' => 'Link reset password telah dikirim ke email kamu.'
    ]);
}

    public function showResetForm()
    {
        return view('auth.reset_password');
    }

    public function handleReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8'
        ]);

        $tables = [
            'pembeli' => 'pembeli',
            'penitip' => 'penitip',
            'organisasi' => 'organisasi',
            'pegawai' => 'pegawai',
        ];

        foreach ($tables as $role => $table) {
            $user = DB::table($table)->where('email', $request->email)->first();
            if ($user) {
                DB::table($table)->where('email', $request->email)->update([
                    'password' => Hash::make($request->new_password),
                    'updated_at' => now()
                ]);

                return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
            }
        }

        return back()->with('status', 'Email tidak ditemukan.');
    }
}