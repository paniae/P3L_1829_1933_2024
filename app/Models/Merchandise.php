<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Merchandise
 * 
 * @property string $id_merch
 * @property string $id_pegawai
 * @property string $nama_merch
 * @property int $stok
 * @property int $harga_poin
 * 
 * @property Pegawai $pegawai
 * @property Collection|TukarPoin[] $tukar_poins
 *
 * @package App\Models
 */
class Merchandise extends Model
{
	protected $table = 'merchandise';
	protected $primaryKey = 'id_merch';
	public $incrementing = false;
	public $timestamps = false;
	protected $keyType = 'string';

	protected $casts = [
		'stok' => 'int',
		'harga_poin' => 'int'
	];

	protected $fillable = [
		'id_merch',
		'id_pegawai',
		'nama_merch',
		'stok',
		'harga_poin',
		'gambar_merch'
	];

	public function pegawai()
	{
		return $this->belongsTo(Pegawai::class, 'id_pegawai');
	}

	public function tukar_poins()
	{
		return $this->hasMany(TukarPoin::class, 'id_merch');
	}
}
