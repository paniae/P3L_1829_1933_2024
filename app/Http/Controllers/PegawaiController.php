<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Http; 
use Amenadiel\JpGraph\Plot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use App\Models\Penitip;
use App\Models\RequestDonasi;
use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Pemesanan;
use App\Models\Komisi;

class PegawaiController extends Controller
{

    public function apiProfile($id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->first();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pegawai
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Request store pegawai masuk', $request->all());

        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email',
            'password' => 'required|min:8',
            'nomor_telepon' => 'required|string|max:20',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
        ]);

        $idRole = DB::table('role')->where('nama_role', 'pegawai')->value('id_role');
        $lastId = DB::table('pegawai')
            ->selectRaw("MAX(CAST(SUBSTRING(id_pegawai, 2) AS UNSIGNED)) as max_id")
            ->value('max_id');

        $newId = 'P' . ($lastId + 1);

        Pegawai::create([
            'id_pegawai' => $newId,
            'nama_pegawai' => $request->nama_pegawai,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'id_jabatan' => $request->id_jabatan,
            'id_role' => $idRole,
        ]);

        return redirect()->back()->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function adminPegawai()
    {
        $pegawai = Pegawai::all();
        return view('pegawai.admin.adminPegawai', compact('pegawai'));
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->back()->with('success', 'Pegawai berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($request->has('alamat')) {
            $pegawai->alamat = $request->input('alamat');
        }

        if ($request->has('email')) {
            $pegawai->email = $request->input('email');
        }

        if ($request->has('nomor_telepon')) {
            $pegawai->nomor_telepon = $request->input('nomor_telepon');
        }

        if ($request->boolean('reset_password')) {
            $tglLahir = $pegawai->tgl_lahir; 
            if ($tglLahir) {
                $tglLahirFormatted = \Carbon\Carbon::parse($tglLahir)->format('dmY'); // ddmmyyyy
                $pegawai->password = Hash::make($tglLahirFormatted);
            } else {
                return response()->json(['message' => 'Tanggal lahir tidak tersedia untuk reset password.'], 422);
            }
        }

        $pegawai->save();

        return response()->json(['message' => 'Data pegawai berhasil diperbarui.']);
    }

    public function index_cs()
    {
        $penitip = Penitip::all();
        return view('pegawai.cs.index_cs', compact('penitip'));
    }

    public function homeGudang()
    {
        $penitip = Penitip::all();
        $barang = Barang::with('penitip')->get();
        $pegawai = Pegawai::where('id_jabatan', 'J1')->get();

        $hunter = Pegawai::whereHas('jabatan', function ($q) {
            $q->where('nama_jabatan', 'Hunter');
        })->get();

        return view('pegawai.gudang.index_gudang', compact('barang', 'penitip', 'pegawai', 'hunter'));
    }


    public function storeGudang(Request $request)
    {
        try {
            // 1. Validasi data
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'deskripsi_barang' => 'required|string',
                'kategori' => 'required|string',
                'harga_barang' => 'required|numeric|min:0',
                'tgl_titip' => 'required|date',
                'tgl_akhir' => 'required|date',
                'garansi' => 'required|string',
                'status' => 'required|string',
                'id_penitip' => 'required|exists:penitip,id_penitip',
                'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'foto_barang2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'tgl_garansi' => 'nullable|date',
                'id_hunter' => 'nullable|exists:pegawai,id_pegawai',
            ]);

            // 2. Ambil ID pegawai gudang dari session
            $idGudang = session('user_id');

            // 3. Generate ID Barang otomatis
            $prefix = strtoupper(substr($request->nama_barang, 0, 1));
            $lastId = DB::table('barang')
                ->where('id_barang', 'LIKE', $prefix . '%')
                ->selectRaw("MAX(CAST(SUBSTRING(id_barang, 2) AS UNSIGNED)) as max_id")
                ->value('max_id');
            $newId = $prefix . (($lastId ?? 0) + 1);

            // 4. Upload foto barang (jika ada)
            $foto1Name = null;
            if ($request->hasFile('foto_barang')) {
                $foto1 = $request->file('foto_barang');
                $foto1Name = time() . '_1.' . $foto1->getClientOriginalExtension();
                $foto1->move(public_path('image'), $foto1Name);
            }

            $foto2Name = null;
            if ($request->hasFile('foto_barang2')) {
                $foto2 = $request->file('foto_barang2');
                $foto2Name = time() . '_2.' . $foto2->getClientOriginalExtension();
                $foto2->move(public_path('image'), $foto2Name);
            }

            // 5. Simpan ke database
            Barang::create([
                'id_barang' => $newId,
                'nama_barang' => $request->nama_barang,
                'deskripsi_barang' => $request->deskripsi_barang,
                'kategori' => $request->kategori,
                'harga_barang' => $request->harga_barang,
                'berat_barang' => $request->berat_barang, // ← TAMBAHKAN INI
                'tgl_titip' => now(),
                'tgl_laku' => null,
                'tgl_akhir' => $request->tgl_akhir,
                'garansi' => $request->garansi == 1 ? 1 : 0,
                'tgl_garansi' => $request->garansi == 1 ? $request->tgl_garansi : null,
                'status' => $request->status,
                'id_penitip' => $request->id_penitip,
                'id_gudang' => $idGudang,
                'id_hunter' => $request->id_hunter,
                'foto_barang' => $foto1Name,
                'foto_barang2' => $foto2Name,
                'perpanjangan' => 0,
            ]);

            // 6. Ambil nama penitip dari DB
            $penitip = Penitip::findOrFail($request->id_penitip);

            // 7. Return respons JSON (dipakai untuk unduh PDF di frontend)
            return response()->json([
                'message' => 'Barang berhasil ditambahkan.',
                'id_penitip' => $penitip->id_penitip,
                'nama_penitip' => $penitip->nama_penitip,
            ]);

        } catch (\Exception $e) {
            // Tangani error internal
            return response()->json([
                'message' => 'Terjadi error saat menyimpan barang.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function editGudang($id)
    {
        $barang = Barang::findOrFail($id);
        return view('pegawai.gudang.edit_gudang', compact('barang'));
    }

    public function updateGudang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->nama_barang = $request->nama_barang;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->status = $request->status;
        $barang->garansi = $request->garansi;
        $barang->tgl_garansi = $request->tgl_garansi;

        if ($request->hasFile('foto_barang')) {
            $filename = time().'_'.$request->file('foto_barang')->getClientOriginalName();
            $request->file('foto_barang')->move(public_path('image'), $filename);
            $barang->foto_barang = $filename;
        }

        if ($request->hasFile('foto_barang2')) {
            $filename2 = time().'_'.$request->file('foto_barang2')->getClientOriginalName();
            $request->file('foto_barang2')->move(public_path('image'), $filename2);
            $barang->foto_barang2 = $filename2;
        }

        $barang->save();

        return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroyGudang($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('pegawai.gudang')->with('success', 'Barang berhasil dihapus.');
    }

    public function viewGudang()
    {
        $barang = Barang::all();
        return view('pegawai.gudang.index_gudang', compact('barang'));
    }

    #data ambil barang penitip
    public function ambilBarangList()
{
    $today = Carbon::now();

    // Ambil semua barang dengan status 'akan diambil' dan tgl_ambil sudah lewat lebih dari 7 hari
    $expiredBarang = Barang::where('status', 'akan diambil')
        ->whereDate('tgl_akhir', '<', $today->copy()->subDays(7))
        ->get();

    // Update status menjadi "barang untuk donasi"
    foreach ($expiredBarang as $barang) {
        $barang->status = 'barang untuk donasi';
        $barang->save();
    }

    // Ambil ulang barang yang masih berstatus "akan diambil"
    $barang = Barang::with('penitip')
        ->where('status', 'akan diambil')
        ->get();

    return view('pegawai.gudang.ambilBarangPenitip', compact('barang'));
}

    public function setBarangDiambil($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->status = 'diambil kembali';
        $barang->tgl_ambil = now();

        $barang->save();

        return back()->with('success', 'Barang telah ditandai sebagai diambil kembali.');
    }

    public function setBarangTidakDiambil($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->status = 'barang untuk donasi';
        $barang->save();

        return back()->with('success', 'Barang ditandai tidak diambil dan siap untuk donasi.');
    }

    public function jadwalPengiriman()
    {
        $pemesanan = Pemesanan::with(['pembeli', 'detailPemesanans.barang'])
            ->where('jenis_pengantaran', 'dikirim')
            ->where('status_pembayaran', 'valid')
            ->get();

        $kurirList = Pegawai::whereHas('jabatan', function ($query) {
            $query->where('nama_jabatan', 'Kurir');
        })->get();

        return view('pegawai.gudang.jadwalPengiriman', compact('pemesanan', 'kurirList'));
    }

    public function tugaskanKurir(Request $request, $id)
    {
        $request->validate([
            'id_kurir' => 'required|exists:pegawai,id_pegawai',
        ]);

        Pemesanan::where('id_pemesanan', $id)->update([
            'id_kurir' => $request->id_kurir,
            'status' => 'proses pengiriman'
        ]);

        return redirect()->route('transaksi.dikirim')->with('success', 'Kurir berhasil ditugaskan.');
    }

    public function verifikasiPembayaran(Request $request, $id = null)
    {
        if ($request->isMethod('post') && $id) {
            $status = $request->input('status'); // 'disiapkan' atau 'batal'

            if (!in_array($status, ['disiapkan', 'batal'])) {
                return redirect()->back()->with('error', 'Status validasi tidak valid.');
            }

            $pemesanan = Pemesanan::with('pembeli', 'detailPemesanans.barang')->findOrFail($id);
            $user = $pemesanan->pembeli;

            if ($status === 'disiapkan') {
                $pemesanan->status = 'disiapkan';
                $pemesanan->status_pembayaran = 'valid';

                // Tambahkan poin ke user hanya saat pembayaran valid
                $totalPoin = $pemesanan->poin_pesanan ?? 0;
                if ($totalPoin > 0) {
                    $user->poin += $totalPoin;
                    $user->save();
                }

                if ($pemesanan->jenis_pengantaran === 'kurir') {
                    $tglPembayaran = $pemesanan->tgl_pembayaran;

                    if ($tglPembayaran) {
                        $jamPembayaran = Carbon::parse($tglPembayaran)->format('H:i:s');
                        $batasJam = '16:00:00';

                        if ($jamPembayaran < $batasJam) {
                            // Pengiriman hari yang sama dengan tgl_pesan
                            $pemesanan->tgl_kirim = $pemesanan->tgl_pesan;
                            $pemesanan->tgl_ambil = null;
                        } else {
                            // Pengiriman hari berikutnya dari tgl_pembayaran, jam mulai 00:00
                            $pemesanan->tgl_kirim = Carbon::parse($tglPembayaran)->addDay()->startOfDay();
                            $pemesanan->tgl_ambil = null;
                        }
                    }
                } elseif ($pemesanan->jenis_pengantaran === 'diambil') {
                    $pemesanan->tgl_kirim = null;
                    $pemesanan->tgl_ambil = null;
                }
            } else { // status batal
                $pemesanan->status = 'batal';
                $pemesanan->status_pembayaran = 'tidak valid';
                $pemesanan->tgl_kirim = null;
                $pemesanan->tgl_ambil = null;

                // Kembalikan status barang ke 'tersedia'
                foreach ($pemesanan->detailPemesanans as $detail) {
                    $barang = $detail->barang;
                    if ($barang) {
                        $barang->status = 'tersedia';
                        $barang->save();
                    }
                }

                // Jangan tambahkan poin saat batal!
            }

            $pemesanan->save();

            // TODO: Kirim notifikasi ke pembeli, penitip, dan kurir jika perlu

            return redirect()->back()->with('success', "Status pemesanan {$pemesanan->id_pemesanan} berhasil diubah menjadi {$status}.");
        }

        // Jika request GET dan tidak ada id, tampilkan list pemesanan yang perlu verifikasi
        $pemesananList = Pemesanan::with('pembeli')
                            ->where('status', 'diproses')
                            ->get();

        return view('pegawai.cs.verifikasi-pembayaran-cs', ['pemesanan' => $pemesananList]);
    }

    
    public function getKomisiTotal($id)
    {
        $total = Komisi::where('id_pegawai', $id)->sum('komisi_hunter');

        return response()->json([
            'id_pegawai' => $id,
            'total_komisi' => $total,
        ]);
    }

    public function getKomisiList($id)
    {
        try {
            $komisi = Komisi::with('barang')  // Tambahkan relasi barang
                ->where('id_pegawai', $id)
                ->get();

            return response()->json([
                'data' => $komisi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function laporanPenjualanBulanan(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Query penjualan bulanan dari dua tabel
        $laporanBulanan = DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pemesanan', '=', 'detail_pemesanan.id_pemesanan')
            ->select(
                DB::raw('MONTH(pemesanan.tgl_pembayaran) as bulan'),
                DB::raw('COUNT(detail_pemesanan.id_detail_pemesanan) as jumlah_terjual'),
                DB::raw('SUM(detail_pemesanan.harga) as penjualan_kotor')
            )
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->groupBy(DB::raw('MONTH(pemesanan.tgl_pembayaran)'))
            ->orderBy(DB::raw('MONTH(pemesanan.tgl_pembayaran)'))
            ->get();

        // Mapping ke nama bulan biar rapi tampil di Blade
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = $laporanBulanan->firstWhere('bulan', $i);
            $result[] = [
                'bulan' => $bulanIndo[$i],
                'jumlah_terjual' => $found ? $found->jumlah_terjual : 0,
                'penjualan_kotor' => $found ? $found->penjualan_kotor : 0
            ];
        }

        return view('pegawai.owner.laporan_penjualan_bulan', [
            'tahun' => $tahun,
            'laporanBulanan' => $result,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
    }

    public function cetakNotaBulanan(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $laporanBulanan = DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pemesanan', '=', 'detail_pemesanan.id_pemesanan')
            ->select(
                DB::raw('MONTH(pemesanan.tgl_pembayaran) as bulan'),
                DB::raw('COUNT(detail_pemesanan.id_detail_pemesanan) as jumlah_terjual'),
                DB::raw('SUM(detail_pemesanan.harga) as penjualan_kotor')
            )
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->groupBy(DB::raw('MONTH(pemesanan.tgl_pembayaran)'))
            ->orderBy(DB::raw('MONTH(pemesanan.tgl_pembayaran)'))
            ->get();

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = $laporanBulanan->firstWhere('bulan', $i);
            $result[] = [
                'bulan' => $bulanIndo[$i],
                'jumlah_terjual' => $found ? $found->jumlah_terjual : 0,
                'penjualan_kotor' => $found ? $found->penjualan_kotor : 0
            ];
        }

        // Siapkan chart untuk QuickChart.io
        $labels = array_map(fn($item) => $item['bulan'], $result);
        $data = array_map(fn($item) => $item['penjualan_kotor'], $result);
        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Penjualan Kotor',
                    'data' => $data,
                    'backgroundColor' => 'rgba(32, 83, 114, 0.85)'
                ]]
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];
        $url = 'https://quickchart.io/chart?width=700&height=350&format=png&devicePixelRatio=2&c=' . urlencode(json_encode($chartConfig));
        $img = Http::get($url)->body();
        $chartBase64 = 'data:image/png;base64,' . base64_encode($img);

        $pdf = \PDF::loadView('pegawai.owner.nota_penjualan_pdf', [
            'tahun' => $tahun,
            'laporanBulanan' => $result,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
            'chartBase64' => $chartBase64
        ]);
        return $pdf->stream('Laporan_Penjualan_Bulanan_' . $tahun . '.pdf');
    }

    public function laporanKomisiBulanan(Request $request)
    {
        // Ambil bulan & tahun dari input, default bulan ini & tahun ini (dalam angka)
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));

        // Query rekap komisi tiap produk laku di bulan ini
        $list = DB::table('barang')
            ->join('detail_pemesanan', 'barang.id_barang', '=', 'detail_pemesanan.id_barang')
            ->join('pemesanan', 'detail_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'barang.harga_barang as harga_jual',
                'barang.tgl_titip',
                'pemesanan.tgl_pembayaran as tgl_laku',
                'barang.status',
                'barang.id_hunter',
                'barang.tgl_akhir'
            )
            ->whereMonth('pemesanan.tgl_pembayaran', $bulan)
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->distinct()
            ->get();

        // Hitung komisi/bonus per produk sesuai aturan
        $data = [];
        foreach ($list as $b) {
            $harga = (int) $b->harga_jual;
            $komisiMart = 0.2 * $harga;
            $komisiHunter = ($b->id_hunter) ? 0.05 * $harga : 0;
            $bonusPenitip = 0;

            $tglMasuk = $b->tgl_titip;
            $tglLaku = $b->tgl_laku;

            // Bonus penitip jika laku < 7 hari
            if ($tglMasuk && $tglLaku) {
                $days = Carbon::parse($tglMasuk)->diffInDays(Carbon::parse($tglLaku));
                if ($days < 7) {
                    $bonusPenitip = 0.1 * $komisiMart;
                    $komisiMart -= $bonusPenitip;
                }
            }
            // Perpanjangan/lebih dari 1 bulan, hunter = 0, mart 30%
            if ($b->tgl_akhir && $tglLaku) {
                $masuk = Carbon::parse($tglMasuk);
                $akhir = Carbon::parse($b->tgl_akhir);
                $laku = Carbon::parse($tglLaku);
                if ($akhir->diffInDays($masuk) >= 30 && $laku > $akhir) {
                    $komisiMart = 0.3 * $harga;
                    $komisiHunter = 0;
                    $bonusPenitip = 0;
                }
            }

            $data[] = [
                'kode_produk' => $b->kode_produk,
                'nama_produk' => $b->nama_produk,
                'harga_jual' => $harga,
                'tgl_masuk' => $tglMasuk ? Carbon::parse($tglMasuk)->format('d/m/Y') : '',
                'tgl_laku' => $tglLaku ? Carbon::parse($tglLaku)->format('d/m/Y') : '',
                'komisi_hunter' => $komisiHunter,
                'komisi_mart' => $komisiMart,
                'bonus_penitip' => $bonusPenitip,
            ];
        }

        // Kirim semua ke Blade
        return view('pegawai.owner.laporan_komisi_bulanan', [
            'bulan' => $bulan, // angka
            'tahun' => $tahun,
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
    }

    public function cetakKomisiBulanan(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));

        // (copy-paste logic di atas)
        $list = DB::table('barang')
            ->join('detail_pemesanan', 'barang.id_barang', '=', 'detail_pemesanan.id_barang')
            ->join('pemesanan', 'detail_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'barang.harga_barang as harga_jual',
                'barang.tgl_titip',
                'pemesanan.tgl_pembayaran as tgl_laku',
                'barang.status',
                'barang.id_hunter',
                'barang.tgl_akhir'
            )
            ->whereMonth('pemesanan.tgl_pembayaran', $bulan)
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->distinct()
            ->get();

        $data = [];
        foreach ($list as $b) {
            $harga = (int) $b->harga_jual;
            $komisiMart = 0.2 * $harga;
            $komisiHunter = ($b->id_hunter) ? 0.05 * $harga : 0;
            $bonusPenitip = 0;

            $tglMasuk = $b->tgl_titip;
            $tglLaku = $b->tgl_laku;

            // Bonus penitip jika laku < 7 hari
            if ($tglMasuk && $tglLaku) {
                $days = Carbon::parse($tglMasuk)->diffInDays(Carbon::parse($tglLaku));
                if ($days < 7) {
                    $bonusPenitip = 0.1 * $komisiMart;
                    $komisiMart -= $bonusPenitip;
                }
            }
            // Perpanjangan/lebih dari 1 bulan, hunter = 0, mart 30%
            if ($b->tgl_akhir && $tglLaku) {
                $masuk = Carbon::parse($tglMasuk);
                $akhir = Carbon::parse($b->tgl_akhir);
                $laku = Carbon::parse($tglLaku);
                if ($akhir->diffInDays($masuk) >= 30 && $laku > $akhir) {
                    $komisiMart = 0.3 * $harga;
                    $komisiHunter = 0;
                    $bonusPenitip = 0;
                }
            }

            $data[] = [
                'kode_produk' => $b->kode_produk,
                'nama_produk' => $b->nama_produk,
                'harga_jual' => $harga,
                'tgl_masuk' => $tglMasuk ? Carbon::parse($tglMasuk)->format('d/m/Y') : '',
                'tgl_laku' => $tglLaku ? Carbon::parse($tglLaku)->format('d/m/Y') : '',
                'komisi_hunter' => $komisiHunter,
                'komisi_mart' => $komisiMart,
                'bonus_penitip' => $bonusPenitip,
            ];
        }

        $pdf = PDF::loadView('pegawai.owner.nota_komisi_pdf', [
            'bulan' => $bulan, // angka
            'tahun' => $tahun,
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ]);
        return $pdf->stream('Laporan_Komisi_Bulanan_' . $bulan . '_' . $tahun . '.pdf');
    }

    public function laporanStokGudang(Request $request)
    {
        // Ambil semua barang stok hari ini (bisa tambah filter status: tersedia/didonasikan/dll sesuai kebutuhan)
        $barang = DB::table('barang')
            ->leftJoin('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->leftJoin('pegawai as hunter', 'barang.id_hunter', '=', 'hunter.id_pegawai')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'penitip.id_penitip',
                'penitip.nama_penitip',
                'barang.tgl_titip as tgl_masuk',
                'barang.perpanjangan',
                'barang.id_hunter',
                'hunter.nama_pegawai as nama_hunter',
                'barang.harga_barang'
            )
            ->whereIn('barang.status', ['tersedia', 'didonasikan']) // stok "live" saja
            ->get();

        // Mapping ulang untuk perpanjangan
        $data = [];
        foreach ($barang as $b) {
            $data[] = [
                'kode_produk'   => $b->kode_produk,
                'nama_produk'   => $b->nama_produk,
                'id_penitip'    => $b->id_penitip,
                'nama_penitip'  => $b->nama_penitip,
                'tgl_masuk'     => $b->tgl_masuk ? \Carbon\Carbon::parse($b->tgl_masuk)->format('d/m/Y') : '',
                'perpanjangan'  => $b->perpanjangan ? 'Ya' : 'Tidak',
                'id_hunter'     => $b->id_hunter ?? '-',
                'nama_hunter'   => $b->nama_hunter ?? '-',
                'harga'         => $b->harga_barang,
            ];
        }

        return view('pegawai.owner.laporan_stok_gudang', [
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
    }

    public function cetakStokGudang(Request $request)
    {
        $barang = DB::table('barang')
            ->leftJoin('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->leftJoin('pegawai as hunter', 'barang.id_hunter', '=', 'hunter.id_pegawai')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'penitip.id_penitip',
                'penitip.nama_penitip',
                'barang.tgl_titip as tgl_masuk',
                'barang.perpanjangan',
                'barang.id_hunter',
                'hunter.nama_pegawai as nama_hunter',
                'barang.harga_barang'
            )
            ->whereIn('barang.status', ['tersedia', 'didonasikan'])
            ->get();

        $data = [];
        foreach ($barang as $b) {
            $data[] = [
                'kode_produk'   => $b->kode_produk,
                'nama_produk'   => $b->nama_produk,
                'id_penitip'    => $b->id_penitip,
                'nama_penitip'  => $b->nama_penitip,
                'tgl_masuk'     => $b->tgl_masuk ? \Carbon\Carbon::parse($b->tgl_masuk)->format('d/m/Y') : '',
                'perpanjangan'  => $b->perpanjangan ? 'Ya' : 'Tidak',
                'id_hunter'     => $b->id_hunter ?? '-',
                'nama_hunter'   => $b->nama_hunter ?? '-',
                'harga'         => $b->harga_barang,
            ];
        }

        $pdf = \PDF::loadView('pegawai.owner.nota_stok_gudang_pdf', [
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
        return $pdf->stream('Laporan_Stok_Gudang_' . date('Ymd') . '.pdf');
    }

    public function laporanPenjualanKategori(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Daftar kategori (bisa dari tabel kategori, atau hardcode array)
        $kategoriList = [
            'Elektronik & Gadget',
            'Pakaian & Aksesoris',
            'Perabotan Rumah Tangga',
            'Buku, Alat Tulis, & Peralatan Sekolah',
            'Hobi, Mainan, & Koleksi',
            'Perlengkapan Bayi & Anak',
            'Otomotif & Aksesoris',
            'Perlengkapan Taman & Outdoor',
            'Peralatan Kantor & Industri',
            'Kosmetik & Perawatan Diri',
        ];

        // Query jumlah barang TERJUAL per kategori
        $terjual = DB::table('detail_pemesanan')
            ->join('barang', 'detail_pemesanan.id_barang', '=', 'barang.id_barang')
            ->join('pemesanan', 'detail_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->select('barang.kategori', DB::raw('COUNT(*) as item_terjual'))
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->groupBy('barang.kategori')
            ->pluck('item_terjual', 'barang.kategori');

        // Query jumlah barang GAGAL TERJUAL per kategori
        $gagal = DB::table('barang')
            ->select('kategori', DB::raw('COUNT(*) as item_gagal'))
            ->whereYear('tgl_akhir', $tahun)
            ->whereIn('status', ['barang untuk donasi', 'tidak laku', 'kadaluarsa']) // contoh status gagal
            ->groupBy('kategori')
            ->pluck('item_gagal', 'kategori');

        // Gabungkan hasil ke array untuk Blade
        $data = [];
        foreach ($kategoriList as $kategori) {
            $data[] = [
                'kategori' => $kategori,
                'item_terjual' => $terjual[$kategori] ?? 0,
                'item_gagal'   => $gagal[$kategori] ?? 0,
            ];
        }

        return view('pegawai.owner.laporan_penjualan_kategori', [
            'tahun' => $tahun,
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ]);
    }

    public function cetakLaporanPenjualanKategori(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $kategoriList = [
            'Elektronik & Gadget',
            'Pakaian & Aksesoris',
            'Perabotan Rumah Tangga',
            'Buku, Alat Tulis, & Peralatan Sekolah',
            'Hobi, Mainan, & Koleksi',
            'Perlengkapan Bayi & Anak',
            'Otomotif & Aksesoris',
            'Perlengkapan Taman & Outdoor',
            'Peralatan Kantor & Industri',
            'Kosmetik & Perawatan Diri',
        ];

        // Ambil data terjual
        $terjual = DB::table('detail_pemesanan')
            ->join('barang', 'detail_pemesanan.id_barang', '=', 'barang.id_barang')
            ->join('pemesanan', 'detail_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->select('barang.kategori', DB::raw('COUNT(*) as item_terjual'))
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->groupBy('barang.kategori')
            ->pluck('item_terjual', 'barang.kategori');

        // Ambil data gagal
        $gagal = DB::table('barang')
            ->select('kategori', DB::raw('COUNT(*) as item_gagal'))
            ->whereYear('tgl_akhir', $tahun)
            ->whereIn('status', ['barang untuk donasi', 'tidak laku', 'kadaluarsa'])
            ->groupBy('kategori')
            ->pluck('item_gagal', 'kategori');

        // Gabungkan data
        $data = [];
        foreach ($kategoriList as $kategori) {
            $data[] = [
                'kategori' => $kategori,
                'item_terjual' => $terjual[$kategori] ?? 0,
                'item_gagal' => $gagal[$kategori] ?? 0,
            ];
        }

        // Buat PDF
        $pdf = \PDF::loadView('pegawai.owner.nota_penjualan_kategori_pdf', [
            'tahun' => $tahun,
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ]);

        return $pdf->stream('Laporan_Penjualan_Kategori_' . $tahun . '.pdf');
    }


    public function laporanBarangExpired(Request $request)
    {
        $today = now()->format('Y-m-d');
        // Query barang expired hari ini
        $barang = DB::table('barang')
            ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'barang.id_penitip',
                'penitip.nama_penitip',
                'barang.tgl_titip as tgl_masuk',
                'barang.tgl_akhir',
                DB::raw('DATE_ADD(barang.tgl_akhir, INTERVAL 7 DAY) as batas_ambil')
            )
            ->where('barang.tgl_akhir', '<=', $today)
            ->orderBy('barang.tgl_akhir')
            ->get();

        $data = [];
        foreach ($barang as $b) {
            $data[] = [
                'kode_produk' => $b->kode_produk,
                'nama_produk' => $b->nama_produk,
                'id_penitip' => $b->id_penitip,
                'nama_penitip' => $b->nama_penitip,
                'tgl_masuk' => $b->tgl_masuk ? \Carbon\Carbon::parse($b->tgl_masuk)->format('d/m/Y') : '',
                'tgl_akhir' => $b->tgl_akhir ? \Carbon\Carbon::parse($b->tgl_akhir)->format('d/m/Y') : '',
                'batas_ambil' => $b->batas_ambil ? \Carbon\Carbon::parse($b->batas_ambil)->format('d/m/Y') : '',
            ];
        }

        return view('pegawai.owner.laporan_barang_expired', [
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
    }

    public function cetakLaporanBarangExpired(Request $request)
    {
        $today = now()->format('Y-m-d');
        $barang = DB::table('barang')
            ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'barang.id_penitip',
                'penitip.nama_penitip',
                'barang.tgl_titip as tgl_masuk',
                'barang.tgl_akhir',
                DB::raw('DATE_ADD(barang.tgl_akhir, INTERVAL 7 DAY) as batas_ambil')
            )
            ->where('barang.tgl_akhir', '<=', $today)
            ->orderBy('barang.tgl_akhir')
            ->get();

        $data = [];
        foreach ($barang as $b) {
            $data[] = [
                'kode_produk'   => $b->kode_produk,
                'nama_produk'   => $b->nama_produk,
                'id_penitip'    => $b->id_penitip,
                'nama_penitip'  => $b->nama_penitip,
                'tgl_masuk'     => $b->tgl_masuk ? \Carbon\Carbon::parse($b->tgl_masuk)->format('d/m/Y') : '',
                'tgl_akhir'     => $b->tgl_akhir ? \Carbon\Carbon::parse($b->tgl_akhir)->format('d/m/Y') : '',
                'batas_ambil'   => $b->batas_ambil ? \Carbon\Carbon::parse($b->batas_ambil)->format('d/m/Y') : '',
            ];
        }

        $pdf = \PDF::loadView('pegawai.owner.nota_barang_expired_pdf', [
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
        return $pdf->stream('Laporan_Barang_Expired_' . now()->format('Ymd') . '.pdf');
    }

    public function laporanDonasiBarang(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));

    $data = DB::table('donasi')
        ->join('barang', 'donasi.id_barang', '=', 'barang.id_barang')
        ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
        ->join('organisasi', 'donasi.id_organisasi', '=', 'organisasi.id_organisasi')
        ->select(
            'barang.id_barang as kode_produk',
            'barang.nama_barang as nama_produk',
            'penitip.id_penitip',
            'penitip.nama_penitip',
            'donasi.tgl_donasi',
            'organisasi.nama_organisasi',
            'donasi.nama_penerima'
        )
        ->whereYear('donasi.tgl_donasi', $tahun)
        ->orderBy('donasi.tgl_donasi', 'asc')
        ->get();

    return view('pegawai.owner.laporan_donasi_barang', [
        'tahun' => $tahun,
        'data' => $data,
        'tanggalCetak' => now()->translatedFormat('d F Y')
    ]);
}

public function cetakDonasiBarang(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));

    $data = DB::table('donasi')
        ->join('barang', 'donasi.id_barang', '=', 'barang.id_barang')
        ->join('penitip', 'barang.id_penitip', '=', 'penitip.id_penitip')
        ->join('organisasi', 'donasi.id_organisasi', '=', 'organisasi.id_organisasi')
        ->select(
            'barang.id_barang as kode_produk',
            'barang.nama_barang as nama_produk',
            'penitip.id_penitip',
            'penitip.nama_penitip',
            'donasi.tgl_donasi',
            'organisasi.nama_organisasi',
            'donasi.nama_penerima'
        )
        ->whereYear('donasi.tgl_donasi', $tahun)
        ->orderBy('donasi.tgl_donasi', 'asc')
        ->get();

    $pdf = \PDF::loadView('pegawai.owner.nota_donasi_pdf', [
        'tahun' => $tahun,
        'data' => $data,
        'tanggalCetak' => now()->translatedFormat('d F Y')
    ]);

    return $pdf->stream('Laporan_Donasi_Barang_' . $tahun . '.pdf');
}

    public function laporanRequestDonasi()
    {
        $data = DB::table('request_donasi')
            ->leftJoin('donasi', 'request_donasi.id_request_donasi', '=', 'donasi.id_request_donasi')
            ->join('organisasi', 'request_donasi.id_organisasi', '=', 'organisasi.id_organisasi')
            ->select(
                'request_donasi.id_organisasi',
                'organisasi.nama_organisasi',
                'organisasi.alamat_organisasi',
                'request_donasi.nama_barang_request'
            )
            ->whereNull('donasi.id_request_donasi')
            ->orderBy('request_donasi.id_request_donasi', 'desc')
            ->get();

        return view('pegawai.owner.laporan_request_donasi', [
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
    }

    public function cetakRequestDonasiPDF()
    {
        $data = DB::table('request_donasi')
            ->leftJoin('donasi', 'request_donasi.id_request_donasi', '=', 'donasi.id_request_donasi')
            ->join('organisasi', 'request_donasi.id_organisasi', '=', 'organisasi.id_organisasi')
            ->select(
                'request_donasi.id_organisasi',
                'organisasi.nama_organisasi',
                'organisasi.alamat_organisasi',
                'request_donasi.nama_barang_request'
            )
            ->whereNull('donasi.id_request_donasi')
            ->orderBy('request_donasi.id_request_donasi', 'desc')
            ->get();

        $pdf = \PDF::loadView('pegawai.owner.nota_request_donasi_pdf', [
            'data' => $data,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);

        return $pdf->stream('Laporan_Request_Donasi_' . now()->format('Ymd') . '.pdf');
    }

    public function laporanTransaksiPenitip(Request $request)
    {
        $id_penitip = $request->input('id_penitip');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        // Jika belum dipilih penitip/bulan, langsung return view kosong
        if (!$id_penitip || !$bulan) {
            return view('pegawai.owner.laporan_transaksi_penitip', [
                'penitip' => null
            ]);
        }

        $penitip = DB::table('penitip')->where('id_penitip', $id_penitip)->first();
        if (!$penitip) {
            return back()->with('error', 'Data penitip tidak ditemukan.');
        }

        $data = DB::table('barang')
            ->join('detail_pemesanan', 'barang.id_barang', '=', 'detail_pemesanan.id_barang')
            ->join('pemesanan', 'detail_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->whereMonth('pemesanan.tgl_pembayaran', $bulan)
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('barang.id_penitip', $id_penitip)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'barang.tgl_titip as tanggal_masuk',
                'pemesanan.tgl_pembayaran as tanggal_laku',
                'barang.harga_barang'
            )
            ->get();

        $list = [];
        $totalPendapatan = 0;
        $totalHargaBersih = 0;  // Definisikan variabel totalHargaBersih
        $totalBonus = 0;  // Definisikan variabel totalBonus

        foreach ($data as $item) {
            $harga = (int) $item->harga_barang;
            $komisi = 0.2 * $harga;
            $bonus = 0;

            $masuk = \Carbon\Carbon::parse($item->tanggal_masuk);
            $laku = \Carbon\Carbon::parse($item->tanggal_laku);
            $selisih = $masuk->diffInDays($laku);

            if ($selisih < 7) {
                $bonus = 0.1 * $komisi;
                $komisi -= $bonus;
            }

            $bersih = $harga - $komisi;
            $pendapatan = $bersih + $bonus;
            $totalPendapatan += $pendapatan;
            $totalHargaBersih += $bersih;  // Menambahkan harga bersih ke totalHargaBersih
            $totalBonus += $bonus;  // Menambahkan bonus ke totalBonus

            $list[] = [
                'kode_produk' => $item->kode_produk,
                'nama_produk' => $item->nama_produk,
                'tanggal_masuk' => $masuk->format('d/m/Y'),
                'tanggal_laku' => $laku->format('d/m/Y'),
                'harga_bersih' => $bersih,
                'bonus' => $bonus,
                'pendapatan' => $pendapatan,
            ];
        }

        return view('pegawai.owner.laporan_transaksi_penitip', [
            'data' => $list,
            'total' => $totalPendapatan,
            'totalHargaBersih' => $totalHargaBersih,  // Pastikan variabel ini ada di view
            'totalBonus' => $totalBonus,  // Pastikan variabel ini ada di view
            'penitip' => $penitip,
            'id_penitip' => $penitip->id_penitip,
            'nama_penitip' => $penitip->nama_penitip,
            'bulan' => \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F'),
            'tahun' => $tahun,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);
    }



    public function cetakTransaksiPenitipPDF(Request $request)
    {
        $bulan = (int) $request->input('bulan');
        $tahun = (int) $request->input('tahun', date('Y'));
        $id_penitip = $request->input('id_penitip');

        if (!$id_penitip || !$bulan) {
            return back()->with('error', 'Silakan pilih penitip dan bulan terlebih dahulu.');
        }

        $penitip = DB::table('penitip')->where('id_penitip', $id_penitip)->first();
        if (!$penitip) {
            return back()->with('error', 'Data penitip tidak ditemukan.');
        }

        $data = DB::table('barang')
            ->join('detail_pemesanan', 'barang.id_barang', '=', 'detail_pemesanan.id_barang')
            ->join('pemesanan', 'detail_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->whereMonth('pemesanan.tgl_pembayaran', $bulan)
            ->whereYear('pemesanan.tgl_pembayaran', $tahun)
            ->where('barang.id_penitip', $id_penitip)
            ->where('pemesanan.status_pembayaran', 'valid')
            ->select(
                'barang.id_barang as kode_produk',
                'barang.nama_barang as nama_produk',
                'barang.tgl_titip as tanggal_masuk',
                'pemesanan.tgl_pembayaran as tanggal_laku',
                'barang.harga_barang'
            )
            ->get();

        $list = [];
        $totalPendapatan = 0;
        $totalHargaBersih = 0;  // Menambahkan variabel totalHargaBersih
        $totalBonus = 0;  // Menambahkan variabel totalBonus

        foreach ($data as $item) {
            $harga = (int) $item->harga_barang;
            $komisi = 0.2 * $harga;
            $bonus = 0;

            $masuk = \Carbon\Carbon::parse($item->tanggal_masuk);
            $laku = \Carbon\Carbon::parse($item->tanggal_laku);
            $selisih = $masuk->diffInDays($laku);

            if ($selisih < 7) {
                $bonus = 0.1 * $komisi;
                $komisi -= $bonus;
            }

            $bersih = $harga - $komisi;
            $pendapatan = $bersih + $bonus;

            // Menambahkan ke total
            $totalPendapatan += $pendapatan;
            $totalHargaBersih += $bersih;  // Menambahkan harga bersih
            $totalBonus += $bonus;  // Menambahkan bonus

            $list[] = [
                'kode_produk' => $item->kode_produk,
                'nama_produk' => $item->nama_produk,
                'tanggal_masuk' => $masuk->format('d/m/Y'),
                'tanggal_laku' => $laku->format('d/m/Y'),
                'harga_bersih' => $bersih,
                'bonus' => $bonus,
                'pendapatan' => $pendapatan,
            ];
        }

        // Generate PDF with totals
        $pdf = \PDF::loadView('pegawai.owner.nota_transaksi_penitip_pdf', [
            'data' => $list,
            'total' => $totalPendapatan,
            'totalHargaBersih' => $totalHargaBersih,  // Menambahkan totalHargaBersih
            'totalBonus' => $totalBonus,  // Menambahkan totalBonus
            'id_penitip' => $penitip->id_penitip,
            'nama_penitip' => $penitip->nama_penitip,
            'bulan' => \Carbon\Carbon::create()->month($bulan)->translatedFormat('F'),
            'tahun' => $tahun,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);

        return $pdf->stream('Laporan_Transaksi_Penitip_' . $bulan . '_' . $tahun . '.pdf');
    }


}   