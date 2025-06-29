<?php

namespace App\Http\Controllers;
 use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Penitip;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use PDF;


class PenitipController extends Controller
{

    public function dashboard()
    {
        return view('penitip.barang-titipan');
    }

    public function perpanjanganKedua(Request $request)
    {
        return view('penitip.perpanjangan_kedua');
    }

    public function prosesPerpanjanganKedua($id_barang, Request $request)
    {
        $barang = Barang::findOrFail($id_barang);
        $penitip = Penitip::findOrFail($barang->id_penitip);

        $harga = $barang->harga_barang;
        $potongan = $harga * 0.05;

        if ($penitip->saldo < $potongan) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo tidak mencukupi untuk melakukan perpanjangan.'
            ]);
        }

        if ($barang->perpanjangan > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Barang sudah tidak bisa diperpanjang lagi.'
            ]);
        }

        $tgl_akhir_baru = Carbon::parse($barang->tgl_akhir)->addDays(30);
        $tgl_ambil_baru = Carbon::parse($tgl_akhir_baru)->addDays(7);

        $barang->tgl_akhir = $tgl_akhir_baru->toDateString();
        $barang->tgl_ambil = $tgl_ambil_baru->toDateString();
        $barang->perpanjangan = 2;
        $barang->save();

        $penitip->saldo -= $potongan;
        $penitip->save();

        return response()->json([
            'success' => true,
            'message' => 'Perpanjangan berhasil dilakukan.',
            'saldo_sisa' => $penitip->saldo
        ]);
    }


    public function store(Request $request)
    {
        try {
            \Log::info("Request diterima:", $request->all());

            $request->validate([
                'nama_penitip'   => 'required|string|max:255',
                'email'          => 'required|email|unique:penitip',
                'password'       => 'required|min:8',
                'nomor_telepon'  => 'required|string|max:20',
                'nik_penitip'    => 'required|string|max:50',
                'jenis_kelamin'  => 'required|in:Pria,Wanita',
                'tgl_lahir'      => 'required|date',
                'foto_ktp'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $idRole = DB::table('role')->where('nama_role', 'penitip')->value('id_role');
            if (!$idRole) {
                return response()->json(['success' => false, 'message' => 'Role tidak ditemukan']);
            }

            $lastId = DB::table('penitip')
                ->selectRaw("MAX(CAST(SUBSTRING(id_penitip, 2) AS UNSIGNED)) as max_id")
                ->value('max_id');
            $newId = 'T' . ($lastId + 1);

            $ktpPath = null;
            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $filename = 'ktp_' . Str::slug($request->nama_penitip) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $ktpPath = $file->storeAs('ktp_penitip', $filename, 'public');
            }

            Penitip::create([
                'id_penitip'     => $newId,
                'nama_penitip'   => $request->nama_penitip,
                'email'          => $request->email,
                'password'       => Hash::make($request->password),
                'nomor_telepon'  => $request->nomor_telepon,
                'nik_penitip'    => $request->nik_penitip,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'tgl_lahir'      => $request->tgl_lahir,
                'id_role'        => $idRole,
                'foto_ktp'       => $ktpPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Penitip berhasil ditambahkan.']);

        } catch (\Throwable $e) {
            \Log::error("Gagal menyimpan penitip: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function checkNIK($nik)
    {
        // Check if the NIK already exists in the database
        $exists = Penitip::where('nik_penitip', $nik)->exists();

        // Return response indicating whether the NIK exists or not
        return response()->json(['exists' => $exists]);
    }



    public function showPenitipList()
    {
        $penitip = Penitip::all();
        return view('pegawai.cs.index-cs', compact('penitip'));
    }


    public function searchPenitip(Request $request, $idPegawai)
    {
        $pegawai = DB::table('pegawai')->where('id_pegawai', $idPegawai)->first();

        if (!$pegawai || $pegawai->id_jabatan !== 'J1') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $query = $request->input('q');
        $results = DB::table('penitip')
            ->where('nama_penitip', 'like', '%' . $query . '%')
            ->get();

        return response()->json(['success' => true, 'data' => $results]);
    }

    public function updatePenitip(Request $request, $idPenitip)
    {
        \Log::info("Update Penitip", $request->all());

        // Validate incoming request data
        $validated = $request->validate([
            'nama_penitip'   => 'required|string|max:255',
            'email'          => 'required|email',
            'nomor_telepon'  => 'required|string|max:20',
            'nik_penitip'    => 'required|string|max:50',  // This field is now validated as required
            'jenis_kelamin'  => 'required|in:Pria,Wanita',  // This field is now validated as required
            'tgl_lahir'      => 'required|date',  // This field is now validated as required
        ]);

        // Find the penitip by ID
        $penitip = Penitip::find($idPenitip);

        if (!$penitip) {
            return response()->json(['success' => false, 'message' => 'Penitip tidak ditemukan.'], 404);
        }

        // Update the penitip record with validated data
        $penitip->update([
            'nama_penitip'   => $validated['nama_penitip'],
            'email'          => $validated['email'],
            'nomor_telepon'  => $validated['nomor_telepon'],
            'nik_penitip'    => $validated['nik_penitip'],
            'jenis_kelamin'  => $validated['jenis_kelamin'],
            'tgl_lahir'      => $validated['tgl_lahir'],
        ]);

        return response()->json(['success' => true, 'message' => 'Penitip berhasil diperbarui.']);
    }



    public function deletePenitip($idPenitip)
    {
        $penitip = Penitip::find($idPenitip);

        if (!$penitip) {
            return response()->json(['success' => false, 'message' => 'Penitip tidak ditemukan.'], 404);
        }

        // Delete penitip record
        $penitip->delete();

        return response()->json(['success' => true, 'message' => 'Penitip berhasil dihapus.']);
    }

    public function getHistoryPenjualan($id)
    {
        // Fetch penitip based on the ID
        $penitip = Penitip::find($id);
        
        if (!$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Penitip not found.'
            ]);
        }

        // Get all transactions (barang) for this penitip
        $transactions = DetailPemesanan::with('barang')
            ->whereHas('barang', function ($query) use ($id) {
                $query->where('id_penitip', $id)
                    ->where('status', 'terjual'); // status barang harus 'terjual'
            })
            ->get();

        return response()->json([
            'success' => true,
            'penitip' => $penitip,
            'transactions' => $transactions
        ]);

    }

    public function penitipTitipan()
    {
        $id_penitip = session('id_penitip');
        if (!$id_penitip) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $penitip = Penitip::find($id_penitip); // ✅ ambil data penitip
        $barang = DB::table('barang')->where('id_penitip', $id_penitip)->get();

        return view('penitip.penitipTitipan', compact('barang', 'penitip')); // ✅ kirim ke Blade
    }


    public function detailBarangPenitip($id)
    {
        $id_penitip = session('id_penitip');

        if (!$id_penitip) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data barang
        $barang = DB::table('barang')
            ->where('id_barang', $id)
            ->where('id_penitip', $id_penitip)
            ->first();

        if (!$barang) {
            abort(404, 'Barang tidak ditemukan atau bukan milik Anda.');
        }

        // Konversi tanggal dan hitung selisih
        $tgl_akhir = Carbon::parse($barang->tgl_akhir);
        $now = Carbon::now();
        $selisih = $now->diffInDays($tgl_akhir, false);

        // ✅ Jika perpanjangan == 0, sudah lewat tgl_akhir, dan belum ada tgl_ambil, maka:
        if ($barang->perpanjangan == 0 && $selisih < 0 && !$barang->tgl_ambil && $barang->status !== 'akan diambil') {
            // $tglAmbilBaru = $tgl_akhir->copy()->addDays(7);
            DB::table('barang')
                ->where('id_barang', $id)
                ->update([
                    'status' => 'akan diambil',
                    // 'tgl_ambil' => $tglAmbilBaru
                ]);
            $barang->status = 'akan diambil';
            // $barang->tgl_ambil = $tglAmbilBaru;
        }

        // 🔁 Jika sudah lewat 7 hari dari tgl_akhir dan belum diambil, ubah jadi barang untuk donasi
        if ($selisih < -7 && !$barang->tgl_ambil && $barang->status !== 'barang untuk donasi') {
            DB::table('barang')->where('id_barang', $id)->update(['status' => 'barang untuk donasi']);
            $barang->status = 'barang untuk donasi';
        }

        $penitip = Penitip::find($id_penitip);
        $diskusi = [];

        return view('penitip.detailBarangPenitip', compact('barang', 'diskusi', 'penitip'));
    }



    public function profil()
    {
        $id_penitip = session('id_penitip');
        
        if (!$id_penitip) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $penitip = Penitip::find($id_penitip);

        if (!$penitip) {
            abort(404, 'Data penitip tidak ditemukan.');
        }

        return view('penitip.profil_penitip', compact('penitip'));
    }

    public function apiBarang($id)
    {
        $penitip = Penitip::find($id);

        if (!$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Penitip tidak ditemukan.'
            ], 404);
        }

        $barang = DB::table('barang')->where('id_penitip', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function cetakLaporanPenitip($idPenitip)
    {
        try {
            $penitip = Penitip::findOrFail($idPenitip);

            // Ambil HANYA 1 barang terbaru
            $barang = Barang::with(['penitip', 'gudang', 'hunter'])
                ->where('id_penitip', $idPenitip)
                ->orderByDesc('tgl_titip')
                ->first();


            if (!$barang) {
                return back()->with('error', 'Tidak ada barang penitip ini.');
            }

            $barangList = [$barang]; // Tetap array supaya view tidak error

            $tanggal_titip = $barang->tgl_titip ?? now();
            $masa_akhir = \Carbon\Carbon::parse($tanggal_titip)->addDays(30);

            $pegawaiId = $barang->id_gudang ?? $barang->id_pegawai ?? 'P-?';
            $pegawai = \App\Models\Pegawai::where('id_pegawai', $pegawaiId)->first();
            $pegawaiNama = $pegawai ? $pegawai->nama_pegawai : 'Tidak Diketahui';

            $nota = date('y') . '.' . date('m') . '.' . rand(100, 999);

            return PDF::loadView('pegawai.gudang.laporan_penitip', [
                'penitip' => $penitip,
                'barangList' => $barangList,  // HANYA satu barang (array)
                'tanggal_titip' => $tanggal_titip,
                'masa_akhir' => $masa_akhir,
                'nota' => $nota,
                'pegawai_id' => $pegawaiId,
                'pegawai_nama' => $pegawaiNama,
            ])->download("Nota_Penitipan_{$penitip->nama_penitip}.pdf");
        } catch (\Exception $e) {
            // Untuk debug, jika gagal nanti hapus blok ini agar error asli muncul di browser
            return response('<pre>' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>');
        }
    }

    public function apiProfile($id)
    {
        $penitip = Penitip::where('id_penitip', $id)->first();

        if (!$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Data penitip tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $penitip
        ]);
    }

    public function getBarangPenitip($idPenitip)
    {
        $barang = Barang::where('id_penitip', $idPenitip)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                // Cek status donasi dan tanggal akhir
                $sudahDidonasikan = $item->status === 'didonasikan';
                $melebihiTglAkhir = false;
                if ($item->tgl_akhir) {
                    $melebihiTglAkhir = Carbon::parse($item->tgl_akhir)->isBefore(Carbon::today());
                }
                // Tambahkan field baru untuk penanda ke response
                $item->sudah_didonasikan = $sudahDidonasikan;
                $item->melebihi_tgl_akhir = $melebihiTglAkhir;
                return $item;
            });

        return response()->json([
            'success' => true,
            'data' => $barang,
        ]);
    }

    public function getPenitipHistory($id)
    {
        // Fetch penitip based on the ID
        $penitip = Penitip::find($id);
        
        if (!$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Penitip not found.'
            ]);
        }

        // Get all transactions (barang) for this penitip
        $transactions = DetailPemesanan::with('barang')
            ->whereHas('barang', function ($query) use ($id) {
                $query->where('id_penitip', $id)
                    ->where('status', 'terjual'); // status barang harus 'terjual'
            })
            ->get();

        return response()->json([
            'success' => true,
            'penitip' => $penitip,
            'transactions' => $transactions
        ]);
    }

    public function getProfilPenitip($id)
    {
        $penitip = \App\Models\Penitip::select(
            'id_penitip',
            'nama_penitip',
            'email',
            'nomor_telepon',
            'nik_penitip',
            'jenis_kelamin',
            'tgl_lahir',
            'rating',
            'saldo',
            'poin'
        )->find($id);

        if (!$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Penitip tidak ditemukan.'
            ], 404);
        }

        // $now = \Carbon\Carbon::now();
        $now = \Carbon\Carbon::create(2025, 7, 1);
        $bulanLalu = $now->copy()->subMonth()->month;
        $tahunLalu = $now->copy()->subMonth()->year;

        // Total penjualan bulan lalu penitip ini (PASTIKAN NAMA KOLOM SAMA)
        $totalPenjualan = \DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pemesanan', '=', 'detail_pemesanan.id_pemesanan')
            ->join('barang', 'detail_pemesanan.id_barang', '=', 'barang.id_barang')
            ->where('barang.id_penitip', $id)
            ->where('pemesanan.status', 'transaksi selesai')
            ->whereMonth('pemesanan.tgl_pembayaran', $bulanLalu)
            ->whereYear('pemesanan.tgl_pembayaran', $tahunLalu)
            ->sum('detail_pemesanan.harga'); // <--- Ganti dengan nama field harga di detail_pemesanan

        // Cari top seller bulan lalu
        $topSeller = \DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pemesanan', '=', 'detail_pemesanan.id_pemesanan')
            ->join('barang', 'detail_pemesanan.id_barang', '=', 'barang.id_barang')
            ->where('pemesanan.status', 'transaksi selesai')
            ->whereMonth('pemesanan.tgl_pembayaran', $bulanLalu)
            ->whereYear('pemesanan.tgl_pembayaran', $tahunLalu)
            ->select('barang.id_penitip', \DB::raw('SUM(detail_pemesanan.harga) as total_harga'))
            ->groupBy('barang.id_penitip')
            ->orderByDesc('total_harga')
            ->first();

        $isTopSeller = $topSeller && $topSeller->id_penitip == $id;
        $bonus = $isTopSeller ? round($totalPenjualan * 0.01) : 0;

        // Inject field baru ke model
        $penitip->total_penjualan_bulan_lalu = $totalPenjualan;
        $penitip->bonus_bulan_lalu = $bonus;
        $penitip->is_top_seller_bulan_lalu = $isTopSeller;

        return response()->json([
            'success' => true,
            'data' => $penitip
        ]);
    }

    public function topSellerPenitip()
    {
        // $now = \Carbon\Carbon::now();
        $now = \Carbon\Carbon::create(2025, 7, 1); // Simulasi sekarang bulan Juli 2025
        $bulanLalu = $now->copy()->subMonth()->month;
        $tahunLalu = $now->copy()->subMonth()->year;

        $topPenitip = DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pemesanan', '=', 'detail_pemesanan.id_pemesanan')
            ->join('barang', 'detail_pemesanan.id_barang', '=', 'barang.id_barang')
            ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->where('pemesanan.status', 'transaksi selesai')
            ->whereMonth('pemesanan.tgl_pembayaran', $bulanLalu)
            ->whereYear('pemesanan.tgl_pembayaran', $tahunLalu)
            ->select(
                'penitip.id_penitip',
                'penitip.nama_penitip as nama',
                DB::raw('COUNT(barang.id_barang) as totalBarang'),
                DB::raw('SUM(detail_pemesanan.harga) as totalHarga')
            )
            ->groupBy('penitip.id_penitip', 'penitip.nama_penitip')
            ->orderByDesc('totalHarga')
            ->get();

        // Tambahkan bonus jika perlu
        $topPenitip = $topPenitip->map(function ($item) {
            $item->bonus = round($item->totalHarga * 0.01);
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data' => $topPenitip
        ]);
    }

    public function topSellerByNominal()
    {
        // Mengambil bulan dan tahun lalu
        // $now = \Carbon\Carbon::now();
        $now = \Carbon\Carbon::create(2025, 7, 1);
        $bulanLalu = $now->copy()->subMonth()->month;
        $tahunLalu = $now->copy()->subMonth()->year;

        // Ambil penitip dengan penjualan tertinggi berdasarkan nominal (harga total)
        $topPenitip = DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pemesanan', '=', 'detail_pemesanan.id_pemesanan')
            ->join('barang', 'detail_pemesanan.id_barang', '=', 'barang.id_barang')
            ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->where('pemesanan.status', 'transaksi selesai')
            ->whereMonth('pemesanan.tgl_pembayaran', $bulanLalu)
            ->whereYear('pemesanan.tgl_pembayaran', $tahunLalu)
            ->select(
                'penitip.id_penitip',
                'penitip.nama_penitip as nama',
                DB::raw('SUM(detail_pemesanan.harga) as totalHarga')
            )
            ->groupBy('penitip.id_penitip', 'penitip.nama_penitip')
            ->orderByDesc('totalHarga')
            ->get();

        // Tambahkan bonus jika perlu
        $topPenitip = $topPenitip->map(function ($item) {
            $item->bonus = round($item->totalHarga * 0.01); // Bonus 1% dari total penjualan
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data' => $topPenitip
        ]);
    }

    public function hitungTopSellerBulanan()
    {
        $now = \Carbon\Carbon::now();
        $bulanLalu = $now->copy()->subMonth()->month;
        $tahunLalu = $now->copy()->subMonth()->year;

        // Cari penitip dengan penjualan tertinggi bulan lalu
        $topSeller = DB::table('pemesanan')
            ->select(
                'id_penitip',
                DB::raw('SUM(total_harga_pesanan) as total_penjualan')
            )
            ->where('status', 'transaksi selesai')
            ->whereMonth('tgl_pembayaran', $bulanLalu)
            ->whereYear('tgl_pembayaran', $tahunLalu)
            ->groupBy('id_penitip')
            ->orderByDesc('total_penjualan')
            ->first();

        if ($topSeller) {
            $bonus = round($topSeller->total_penjualan * 0.01);

            // Tambahkan bonus ke saldo penitip
            DB::table('penitip')
                ->where('id_penitip', $topSeller->id_penitip)
                ->increment('saldo', $bonus);

            // Simpan history/top seller (jika ingin histori)
            DB::table('bonus_penitip')->insert([
                'id_penitip' => $topSeller->id_penitip,
                'bulan' => $bulanLalu,
                'tahun' => $tahunLalu,
                'total_penjualan' => $topSeller->total_penjualan,
                'bonus' => $bonus,
                'status' => 'claimed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Top Seller bulanan telah dihitung dan saldo diupdate.']);
    }
}