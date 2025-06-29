<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jabatan
 * 
 * @property string $id_jabatan
 * @property string $nama_jabatan
 * 
 * @property Collection|Pegawai[] $pegawais
 *
 * @package App\Models
 */
class Jabatan extends Model
{
	protected $table = 'jabatan';
	protected $primaryKey = 'id_jabatan';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = ['id_jabatan', 'nama_jabatan'];

	public function pegawai()
	{
		return $this->hasMany(Pegawai::class, 'id_jabatan');
	}
}
