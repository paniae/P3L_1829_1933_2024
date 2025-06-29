<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\PenitipController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\RequestDonasiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\TukarPoinController;
use App\Http\Controllers\PemesananController;

//Route::post('/login', [AuthController::class, 'login']);

Route::get('/penitip/{id}/barang', [PenitipController::class, 'apiBarang']);

// Pastikan import controllernya sesuai!
Route::get('/penitips/{id}/barang-for-notif', [PenitipController::class, 'apiBarangForNotif']);
Route::get('/pembeli/{id}', [PembeliController::class, 'apiProfile']);
Route::get('/penitip/{id}', [PenitipController::class, 'apiProfile']);
Route::get('/pegawai/{id}', [PegawaiController::class, 'apiProfile']);

Route::post('/logout', function () {
    return response()->json(['message' => 'Logged out']);
});

Route::put('/penitip/{id}', [PenitipController::class, 'updatePenitip']);
Route::delete('/penitip/{id}', [PenitipController::class, 'deletePenitip']);
Route::post('/penitip', [PenitipController::class, 'store']);


Route::get('/organisasi/{id}', [OrganisasiController::class, 'apiDetail']);
Route::post('/request_donasi', [RequestDonasiController::class, 'store']);
Route::get('/request_donasi/{id}', [RequestDonasiController::class, 'index']);
Route::put('/request_donasi/{id}', [RequestDonasiController::class, 'update']);
Route::delete('/request_donasi/{id}', [RequestDonasiController::class, 'destroy']);

// Route::get('/penitips/profile/{id}', [PenitipController::class, 'apiProfile'])->name('penitip.profile');
Route::get('/pembelis/profile/{id}', [PembeliController::class, 'apiProfile'])->name('pembeli.profile');

Route::get('/merchandise', [MerchandiseController::class, 'showAllMerchandise']);


Route::get('/penitips/{id}', [PenitipController::class, 'apiProfile']);
Route::get('/penitips/{id}/barang', [PenitipController::class, 'apiBarang']);

Route::get('pembeli/{userId}/alamat', [AlamatController::class, 'index']);
Route::post('pembeli/{userId}/alamat', [AlamatController::class, 'store']);
Route::put('pembeli/{userId}/alamat/{idAlamat}', [AlamatController::class, 'update']);
Route::delete('pembeli/{userId}/alamat/{idAlamat}', [AlamatController::class, 'destroy']);
Route::get('/penitip/{id}/history-penjualan', [PenitipController::class, 'getHistoryPenjualan']);


Route::get('/pemesanan/{id_pembeli}', [PemesananController::class, 'getByPembeli']);

// ---------------------------------------- MOBILE --------------------------------------------

Route::get('/penitip/{id}/barang', [PenitipController::class, 'apiBarang']);
Route::get('/penitip/{idPenitip}/barang', [PenitipController::class, 'getBarangPenitip']);
Route::get('/barang-tersedia', [BarangController::class, 'barangTersedia']);

Route::get('/penitips/{id}/barang-for-notif', [PenitipController::class, 'apiBarangForNotif']);
Route::get('/pembeli/{id}', [PembeliController::class, 'apiProfile']);
Route::get('/penitip/{id}', [PenitipController::class, 'apiProfile']);
Route::get('/pegawai/{id}', [PegawaiController::class, 'apiProfile']);


Route::get('/pegawai/{id}/komisi', [PegawaiController::class, 'getKomisiTotal']);
Route::get('/pegawai/{id}/komisi-list', [PegawaiController::class, 'getKomisiList']);

Route::post('/tukar-poin', [TukarPoinController::class, 'tukar']);
Route::get('/tukar-poin/{id}', [TukarPoinController::class, 'getBelumDiambil']);

Route::get('/barang/hunter/{id}', [BarangController::class, 'getByHunter']);

Route::get('/pembeli/{id}/history-data', [PemesananController::class, 'historyPembelian']);
Route::get('/pembeli/{idPembeli}/history-detail/{idPemesanan}', [PemesananController::class, 'detailPembelian']);


Route::get('/pegawai/{id}/pengiriman', [PemesananController::class, 'pengirimanKurir']);
Route::put('/selesaikan-pesanan/{id}', [PemesananController::class, 'selesaikan']);
Route::get('/kurir/{id}/history', [PemesananController::class, 'historyByKurir']);

Route::get('/top-penitip', [PenitipController::class, 'topSellerPenitip']);
Route::get('/top-seller-by-nominal', [PenitipController::class, 'topSellerByNominal']);
Route::get('/penitip/{id}', [PenitipController::class, 'getProfilPenitip']);