<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestDonasi
 * 
 * @property string $id_request_donasi
 * @property string $id_organisasi
 * @property Carbon $tgl_request_donasi
 * @property string $nama_barang_request
 * 
 * @property Organisasi $organisasi
 * @property Collection|Donasi[] $donasis
 *
 * @package App\Models
 */
class RequestDonasi extends Model
{
	protected $table = 'request_donasi';
	protected $primaryKey = 'id_request_donasi';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tgl_request_donasi' => 'datetime'
	];

	protected $fillable = [
		'id_organisasi',
		'tgl_request_donasi',
		'nama_barang_request',
		'status_req',
	];

	public function organisasi()
	{
		return $this->belongsTo(Organisasi::class, 'id_organisasi');
	}

	public function donasis()
	{
		return $this->hasMany(Donasi::class, 'id_request_donasi');
	}
}