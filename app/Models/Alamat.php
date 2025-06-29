<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Alamat
 * 
 * @property string $id_alamat
 * @property string $id_pembeli
 * @property string $label_alamat
 * @property string $kecamatan
 * @property string $kabupaten
 * @property string $detail_alamat
 * @property string $desa
 * @property bool $default_alamat
 * 
 * @property Pembeli $pembeli
 *
 * @package App\Models
 */
class Alamat extends Model
{
	protected $table = 'alamat';
	protected $primaryKey = 'id_alamat';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'default_alamat' => 'bool'
	];

	protected $fillable = [
		'id_alamat',  
		'id_pembeli',
		'label_alamat',
		'kecamatan',
		'kabupaten',
		'detail_alamat',
		'desa',
		'default_alamat'
	];

	public function pembeli()
	{
		return $this->belongsTo(Pembeli::class, 'id_pembeli');
	}
}