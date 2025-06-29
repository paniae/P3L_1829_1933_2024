<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
	protected $table = 'detail_pemesanan';
	protected $primaryKey = 'id_detail_pemesanan';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'harga' => 'float'
	];

	protected $fillable = [
		'id_detail_pemesanan',
		'id_barang',
		'id_pemesanan',
		'harga'
	];

	public function barang()
	{
		return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
	}

	public function pemesanan()
	{
		return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
	}

}
