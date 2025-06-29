<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DiskusiProduk extends Model
{
    protected $table = 'diskusi_produk';
    protected $primaryKey = 'id_diskusi';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $casts = [
        'tgl_komentar' => 'datetime',
    ];

    protected $fillable = [
        'id_diskusi',
        'id_pegawai',
        'id_pembeli',
        'id_barang',
        'komentar',
        'tgl_komentar',
    ];

    // Relasi ke Barang (produk)
    public function barang()
    {
        // Nama relasi harus konsisten dengan pemanggilan di controller/view
        return $this->belongsTo(Barang::class, 'id_barang');
    }

	public function pembeli()
	{
		return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
	}

	public function pegawai()
	{
		return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
	}
}
