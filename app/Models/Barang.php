<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Barang
 * 
 * @property string $id_barang
 * @property string $id_penitip
 * @property string $id_pegawai
 * @property string $nama_barang
 * @property string $deskripsi_barang
 * @property string $kategori
 * @property float $harga_barang
 * @property Carbon $tgl_titip
 * @property Carbon|null $tgl_garansi
 * @property Carbon|null $tgl_laku
 * @property Carbon $tgl_akhir
 * @property bool $garansi
 * @property string $status
 * 
 * @property Pegawai $pegawai
 * @property Penitip $penitip
 * @property Collection|DetailPemesanan[] $detail_pemesanans
 * @property Collection|DiskusiProduk[] $diskusi_produks
 * @property Collection|Donasi[] $donasis
 *
 * @package App\Models
 */
class Barang extends Model
{
	protected $table = 'barang';
	protected $primaryKey = 'id_barang';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'harga_barang' => 'float',
		'tgl_titip' => 'datetime',
		'tgl_garansi' => 'datetime',
		'tgl_laku' => 'datetime',
		'tgl_akhir' => 'datetime',
		'tgl_ambil' => 'datetime',
		'garansi' => 'bool',
		'perpanjangan' => 'integer',
	];

	protected $fillable = [
		'id_barang', 'nama_barang', 'deskripsi_barang', 'kategori', 'harga_barang', 'berat_barang',
		'tgl_titip', 'tgl_akhir', 'tgl_laku', 'tgl_ambil', 'tgl_garansi', 'garansi',
		'status', 'id_penitip', 'id_gudang', 'id_hunter', 'foto_barang', 'foto_barang2', 'perpanjangan'
	];


	public function gudang()
	{
		return $this->belongsTo(Pegawai::class, 'id_gudang', 'id_pegawai');
	}

	public function hunter()
	{
		return $this->belongsTo(Pegawai::class, 'id_hunter', 'id_pegawai');
	}

	public function penitip()
	{
		return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
	}

	public function detailPemesanan()
	{
		return $this->hasMany(DetailPemesanan::class, 'id_barang', 'id_barang');
	}


	public function diskusi_produks()
	{
		return $this->hasMany(DiskusiProduk::class, 'id_barang');
	}

	public function latestKomentar()
		{
			return $this->hasOne(DiskusiProduk::class, 'id_barang')->latest('tgl_komentar');
		}

	public function donasis()
	{
		return $this->hasMany(Donasi::class, 'id_barang');
	}
	
}