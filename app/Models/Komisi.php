<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
	protected $table = 'komisi';
	protected $primaryKey = 'id_komisi';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'komisi_perusahaan' => 'float',
		'komisi_hunter' => 'float',
		'bonus' => 'float'
	];

	protected $fillable = [
		'id_komisi',
		'id_barang',
		'id_pemesanan',
		'id_pegawai',
		'komisi_perusahaan',
		'komisi_hunter',
		'bonus'
	];

	public function pegawai()
	{
		return $this->belongsTo(Pegawai::class, 'id_pegawai');
	}

	public function pemesanan()
	{
		return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
	}

	public function barang()
	{
		return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
	}

}
