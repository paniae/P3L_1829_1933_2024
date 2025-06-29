<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\RequestDonasiController;
use App\Http\Controllers\DiskusiProdukController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TukarPoinController;
use App\Models\Pembeli;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/api/login', [AuthController::class, 'login']);

Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

Route::get('/', [BarangController::class, 'home'])->name('guest.home');
Route::get('/lihat_semua', [BarangController::class, 'lihatSemua'])->name('guest.lihat_semua');
Route::get('/detail/{id}', [BarangController::class, 'detail'])->name('guest.detail_barang');
Route::get('/kategori/{kategori}', [BarangController::class, 'showByCategory'])->name('guest.per_kategori');
Route::get('/search', [BarangController::class, 'search'])->name('guest.search');
Route::get('/barang/search', [BarangController::class, 'searchBarang']);

Route::get('/penitip/perpanjangan-kedua', [PenitipController::class, 'perpanjanganKedua'])->name('penitip.perpanjangan_kedua');

Route::post('/penitip/perpanjang-kedua/{id_barang}', [PenitipController::class, 'prosesPerpanjanganKedua'])->name('penitip.perpanjang_kedua.post');

Route::get('/penitip/dashboard', function () {
    return redirect()->route('penitip.barangTitipan');
})->name('penitip.dashboard');


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/organisasi/index_organisasi', function () {
    return view('organisasi.index_organisasi');
});

Route::get('/organisasi/request_donasi', function () {
    return view('organisasi.request_donasi');
});

// Route::post('/register/pembeli', [PembeliController::class, 'store'])->name('register.pembeli');
Route::post('/register/pembeli', [PembeliController::class, 'store'])->name('pembeli.register');
Route::post('/register/organisasi', [OrganisasiController::class, 'store'])->name('register.organisasi');
// Route::post('/register/organisasi', [AuthController::class, 'register']);



Route::get('/pegawai/admin', [PegawaiController::class, 'adminPegawai'])->name('pegawai.admin');
Route::get('/pegawai/cs', [PegawaiController::class, 'index_cs'])->name('pegawai.cs');

Route::get('/pegawai/home', [PegawaiController::class, 'home'])->name('pegawai.home');
Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

Route::get('/pembeli/{id}/history-data', [PembeliController::class, 'getPembeliHistory']);
Route::get('/pembeli/history', function () {
    return view('pembeli.history-pembelian');
})->name('pembeli.history');
Route::get('/pembeli-history', [PembeliController::class, 'showHistoryPage']);

Route::get('/penitip/history-penjualan', function () {
    return view('penitip.history-penjualan');
})->name('penitip.history-penjualan');

Route::get('/api/penitip/check-nik/{nik}', [PenitipController::class, 'checkNIK']);

Route::get('/jabatan', [JabatanController::class, 'adminJabatan'])->name('jabatan.admin');
Route::post('/jabatan', [JabatanController::class, 'store'])->name('jabatan.store');
Route::put('/jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

Route::get('/organisasi', [OrganisasiController::class, 'adminOrganisasi'])->name('organisasi.admin');
Route::post('/organisasi', [OrganisasiController::class, 'store'])->name('organisasi.store');
Route::put('/organisasi/{id}', [OrganisasiController::class, 'update'])->name('organisasi.update');
Route::delete('/organisasi/{id}', [OrganisasiController::class, 'destroy'])->name('organisasi.destroy');

Route::get('/merchandise', [MerchandiseController::class, 'adminMerchandise']);
Route::post('/merchandise', [MerchandiseController::class, 'store'])->name('merchandise.store');
Route::put('/merchandise/{id}', [MerchandiseController::class, 'update'])->name('merchandise.update');
Route::delete('/merchandise/{id}', [MerchandiseController::class, 'destroy']);

Route::middleware('web')->group(function () {
    Route::get('/home-beli', [BarangController::class, 'homeBeli'])->name('home_beli');
    Route::get('/lihat-semua-beli', [BarangController::class, 'lihatSemuaBeli'])->name('lihat_semua_beli');
    Route::get('/detail-beli/{id}', [BarangController::class, 'detailBeli'])->name('detail_barang_beli');
    Route::post('/rate-barang/{id}', [BarangController::class, 'rate'])->name('barang.rate');

    Route::get('/set-session', function (Request $request) {
        $request->validate([
            'user_id' => 'required',
            'role' => 'required',
            'nama' => 'required'
        ]);

        Session::put('user_id', $request->user_id);
        Session::put('role', $request->role);
        Session::put('nama', $request->nama);

        return redirect('/home-beli');
    })->name('set.session');

    Route::get('/pembeli/profile/{id}', function ($id) {
        $pembeli = Pembeli::where('id_pembeli', $id)->firstOrFail();
        return view('pembeli.profil', compact('pembeli'));
    })->name('pembeli-profile');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('remove_from_cart');

    Route::post('/komentar', [DiskusiProdukController::class, 'store'])->name('diskusi.store');
    Route::get('/diskusi/barang/{id_barang}', [DiskusiProdukController::class, 'getByBarang'])->name('diskusi.by_barang');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('remove_from_cart');

Route::get('/pembeli/profile/{id}', [PembeliController::class, 'profile'])->name('pembeli-profile');

Route::prefix('diskusi-produk-cs')->group(function () {
    Route::get('/barang/{id_barang}', [DiskusiProdukController::class, 'getByBarang'])->name('diskusi.getByBarang');
    Route::post('/store', [DiskusiProdukController::class, 'store'])->name('diskusi.store');
    Route::delete('/{id_diskusi}', [DiskusiProdukController::class, 'destroy'])->name('diskusi.destroy.cs');
    Route::get('/', [DiskusiProdukController::class, 'index'])->name('diskusi.index');
});
   
Route::get('/pegawai/home', [PegawaiController::class, 'homeGudang'])->name('pegawai.home');
Route::post('/barang/perpanjangan/{id}', [BarangController::class, 'perpanjangan'])->name('barang.perpanjangan');

Route::get('/pegawai/gudang/index_gudang', [PegawaiController::class, 'indexGudang'])->name('pegawai.gudang.index_gudang');

Route::prefix('pegawai/gudang')->group(function () {
    Route::get('/', [PegawaiController::class, 'homeGudang'])->name('pegawai.gudang');
    Route::post('/store', [PegawaiController::class, 'storeGudang'])->name('gudang.store');
    Route::put('/{id}', [PegawaiController::class, 'updateGudang'])->name('gudang.update');
    Route::delete('/{id}', [PegawaiController::class, 'destroyGudang'])->name('gudang.destroy');
});

Route::get('/pembeli-alamat', function () {
    return view('pembeli.index-pembeli');
})->name('pembeli.alamat');

Route::get('pembeli/{userId}/alamat', [AlamatController::class, 'index']);
Route::post('pembeli/{userId}/alamat', [AlamatController::class, 'store']);
Route::put('pembeli/{userId}/alamat/{idAlamat}', [AlamatController::class, 'update']);
Route::delete('pembeli/{userId}/alamat/{idAlamat}', [AlamatController::class, 'destroy']);

Route::get('/pegawai/ownerRDonasi', [RequestDonasiController::class, 'ownerRDonasi'])->name('owner.requestRDonasi');
Route::post('/approve-request-donasi/{idPegawai}/{idRequestDonasi}', [RequestDonasiController::class, 'approveRequestDonasi'])->name('approveRequestDonasi');
Route::get('/owner/ownerHistoryDonasi', [DonasiController::class, 'ownerHistoryDonasi'])->name('owner.ownerHistoryDonasi');
Route::get('/api/donasi/by-organisasi/{idOrganisasi}', [DonasiController::class, 'donasiByOrganisasi']);
Route::post('/donasi/{id}', [DonasiController::class, 'donasi'])->name('donasi.action');

Route::get('/penitip/barang-titipan', [PenitipController::class, 'penitipTitipan'])->name('penitip.barangTitipan');
Route::get('/penitip/profil', [PenitipController::class, 'profil'])->name('penitip.profil_penitip');
Route::get('/penitip/detail-barang/{id}', [PenitipController::class, 'detailBarangPenitip'])->name('penitip.detail_barang');
Route::get('/penitip/{id}/history-penjualan', [PenitipController::class, 'getHistoryPenjualan']);


Route::get('/pembeli-history', function () {
    return view('pembeli.history-pembelian');
});

Route::post('/barang/ambil/{id}', [BarangController::class, 'ambilBarang'])->name('barang.ambil');

Route::post('/barang/ambil-otomatis/{id}', [BarangController::class, 'ambilOtomatis'])->name('barang.ambil.otomatis');

Route::get('/gudang/ambil-barang', [PegawaiController::class, 'ambilBarangList'])->name('gudang.ambil-barang');
Route::post('/gudang/barang-diambil/{id}', [PegawaiController::class, 'setBarangDiambil'])->name('gudang.barang-diambil');
Route::post('/gudang/barang-tidak-diambil/{id}', [PegawaiController::class, 'setBarangTidakDiambil'])->name('gudang.barang-tidak-diambil');

Route::get('/pegawai/transaksi-diambil', [PemesananController::class, 'transaksiDiambil'])->name('transaksi.diambil');

Route::post('/pegawai/pemesanan/{id}/diambil', [PemesananController::class, 'pemesananDiambil'])->name('pemesanan.diambil');

Route::get('/pegawai/transaksi-dikirim', [PemesananController::class, 'transaksiDikirim'])->name('transaksi.dikirim');
Route::post('/pegawai/transaksi-dikirim/{id}', [PemesananController::class, 'konfirmasiPengiriman'])->name('transaksi.konfirmasiPengiriman');
Route::post('/transaksi/konfirmasi/{id}', [PemesananController::class, 'konfirmasiPengiriman'])->name('transaksi.konfirmasi');

Route::post('/pemesanan/diambil/{id}', [PemesananController::class, 'tandaiDiambil'])->name('pemesanan.diambil');

Route::post('/pemesanan/kirim-notifikasi/{id}', [PemesananController::class, 'kirimNotifikasiPembeli'])->name('pemesanan.kirimNotifikasi');

Route::get('/pegawai/nota-pemesanan', [PemesananController::class, 'notaPemesanan'])->name('nota.pemesanan');
Route::get('/pegawai/nota-pemesanan/download/{id}', [PemesananController::class, 'downloadNota'])->name('nota.download');

// Halaman daftar nota pemesanan
Route::get('/pegawai/nota-pemesanan', [PemesananController::class, 'notaPemesanan'])->name('nota.pemesanan');

// Download nota dalam bentuk PDF
Route::get('/pegawai/nota-pemesanan/download/{id}', [PemesananController::class, 'downloadNota'])->name('nota.download');

Route::get('/checkout', [PemesananController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [PemesananController::class, 'store'])->name('checkout.store');
Route::get('/checkout/payment/{id}', [PemesananController::class, 'showPaymentForm'])->name('checkout.payment');
Route::post('/checkout/payment/{id}', [PemesananController::class, 'submitPayment'])->name('checkout.payment.submit');
Route::post('/checkout/payment/cancel/{id}', [PemesananController::class, 'cancelPayment'])->name('checkout.payment.cancel');

Route::get('/checkout/failed', function () {
    return view('pembeli.checkout-failed');
})->name('checkout.failed');

Route::get('/checkout/success', function () {
    return view('pembeli.checkout-success');
})->name('checkout.success');

Route::get('/pegawai/gudang/laporan-penitip/{id}', [PenitipController::class, 'cetakLaporanPenitip'])->name('pegawai.laporanPenitip');


Route::prefix('verifikasi-pembayaran-cs')->group(function () {
    Route::get('/', [PegawaiController::class, 'verifikasiPembayaran'])->name('verifikasi-pembayaran.cs');
    Route::post('/validasi/{id}', [PegawaiController::class, 'verifikasiPembayaran'])->name('verifikasi-pembayaran.validasi');
});



Route::get('/pegawai/gudang/laporan-penitip/{id}', [PenitipController::class, 'cetakLaporanPenitip'])->name('pegawai.laporanPenitip');

// Route untuk halaman laporan penjualan bulanan
Route::get('/owner/laporan-penjualan-bulan', [PegawaiController::class, 'laporanPenjualanBulanan'])->name('owner.laporanPenjualanBulanan');

// Route untuk generate/cetak PDF nota penjualan bulanan
Route::get('/owner/laporan-penjualan-bulan/pdf', [PegawaiController::class, 'cetakNotaBulanan'])->name('nota.pdf');

// View halaman rekap komisi bulanan
Route::get('/owner/laporan-komisi-bulanan', [PegawaiController::class, 'laporanKomisiBulanan'])->name('owner.laporanKomisiBulanan');

// Cetak PDF komisi bulanan
Route::get('/owner/laporan-komisi-bulanan/pdf', [PegawaiController::class, 'cetakKomisiBulanan'])->name('komisi.pdf');

// Halaman web laporan stok gudang
Route::get('/owner/laporan-stok-gudang', [PegawaiController::class, 'laporanStokGudang'])->name('owner.laporanStokGudang');
// Cetak PDF stok gudang
Route::get('/owner/laporan-stok-gudang/pdf', [PegawaiController::class, 'cetakStokGudang'])->name('stokgudang.pdf');

Route::get('/owner/laporan-penjualan-kategori', [PegawaiController::class, 'laporanPenjualanKategori'])->name('owner.laporanPenjualanKategori');
// Cetak PDF laporan kategori
Route::get('/owner/laporan-penjualan-kategori/pdf', [PegawaiController::class, 'cetakLaporanPenjualanKategori'])->name('owner.laporanPenjualanKategori.pdf');

Route::get('/owner/laporan-barang-expired', [PegawaiController::class, 'laporanBarangExpired'])->name('owner.laporanBarangExpired');
Route::get('/owner/laporan-barang-expired/pdf', [PegawaiController::class, 'cetakLaporanBarangExpired'])->name('owner.laporanBarangExpired.pdf');

// TANPA middleware auth
Route::get('/klaim-merchandise-cs', [KlaimMerchandiseController::class, 'index'])->name('cs.klaimMerchandise');
Route::post('/klaim-merchandise/update-tanggal-ambil/{id}', [KlaimMerchandiseController::class, 'updateTanggalAmbil'])->name('cs.klaimMerchandise.updateTanggalAmbil');

Route::get('/tukar-poin-cs', [TukarPoinController::class, 'index'])->name('cs.tukarPoin');
Route::post('/tukar-poin/request', [TukarPoinController::class, 'store'])->name('tukarPoin.request');
Route::post('/tukar-poin/update-tanggal-ambil/{id}', [TukarPoinController::class, 'updateTanggalAmbil']);
Route::post('/tukar-poin/konfirmasi-ambil/{id}', [TukarPoinController::class, 'konfirmasiAmbil']);

Route::get('/laporan-donasi', [PegawaiController::class, 'laporanDonasiBarang'])->name('donasi.laporan');
Route::get('/laporan-donasi/pdf', [PegawaiController::class, 'cetakDonasiBarang'])->name('donasi.pdf');

Route::get('/laporan-request-donasi', [PegawaiController::class, 'laporanRequestDonasi'])->name('requestdonasi.laporan');
Route::get('/laporan-request-donasi/pdf', [PegawaiController::class, 'cetakRequestDonasiPDF'])->name('requestdonasi.pdf');

Route::get('/laporan-transaksi-penitip', [PegawaiController::class, 'laporanTransaksiPenitip'])->name('transaksi.penitip.laporan');
Route::get('/laporan-transaksi-penitip/pdf', [PegawaiController::class, 'cetakTransaksiPenitipPDF'])->name('transaksi.penitip.pdf');

Route::post('/transaksi/jadwalkan/{id}', [PemesananController::class, 'jadwalkanPengiriman'])->name('transaksi.jadwalkan');

