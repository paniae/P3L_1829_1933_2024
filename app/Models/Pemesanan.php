<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
	protected $table = 'pemesanan';
	protected $primaryKey = 'id_pemesanan';
	public $incrementing = false;
	public $timestamps = false;
	protected $keyType = 'string';

	protected $casts = [
		'tgl_pesan' => 'datetime',
		'tgl_kirim' => 'datetime',
		'tgl_ambil' => 'datetime',
		'poin_pesanan' => 'int',
		'tgl_pembayaran' => 'datetime',
		'total_harga_pesanan' => 'float',
		'total_ongkir' => 'float',
		'harga_setelah_ongkir' => 'float',
		'potongan_harga' => 'float',
		'total_harga' => 'float'
	];

	protected $fillable = [
		'id_pemesanan',
		'id_pembeli',
		'id_pegawai',
		'tgl_pesan',
		'tgl_kirim',
		'tgl_ambil',
		'poin_pesanan',
		'status',
		'jenis_pengantaran',
		'tgl_pembayaran',
		'total_harga_pesanan',
		'total_ongkir',
		'harga_setelah_ongkir',
		'potongan_harga',
		'total_harga',
		'bukti_transfer',
		'status_pembayaran'
	];

	public function pegawai()
	{
		return $this->belongsTo(Pegawai::class, 'id_pegawai');
	}

	public function pembeli()
	{
		return $this->belongsTo(Pembeli::class, 'id_pembeli');
	}

	public function detailPemesanans()
	{
		return $this->hasMany(DetailPemesanan::class, 'id_pemesanan', 'id_pemesanan');
	}

	public function komisis()
	{
		return $this->hasMany(Komisi::class, 'id_pemesanan');
	}
}
