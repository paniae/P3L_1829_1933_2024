<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
	protected $table = 'donasi';
	protected $primaryKey = 'id_donasi';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tgl_donasi' => 'datetime'
	];

	protected $fillable = [
		'id_donasi',
		'id_barang',
		'id_request_donasi',
		'id_organisasi',
		'tgl_donasi',
		'nama_penerima'
	];

	public function barang()
	{
		return $this->belongsTo(Barang::class, 'id_barang');
	}

	public function organisasi()
	{
		return $this->belongsTo(Organisasi::class, 'id_organisasi');
	}

	public function request_donasi()
	{
		return $this->belongsTo(RequestDonasi::class, 'id_request_donasi');
	}
}
