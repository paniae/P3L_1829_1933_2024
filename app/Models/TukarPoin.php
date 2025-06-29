<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TukarPoin
 * 
 * @property string $id_tukar_poin
 * @property string $id_pembeli
 * @property string $id_merch
 * @property Carbon $tgl_tukar
 * @property int $jml
 * 
 * @property Merchandise $merchandise
 * @property Pembeli $pembeli
 *
 * @package App\Models
 */
class TukarPoin extends Model
{
	protected $table = 'tukar_poin';
	protected $primaryKey = 'id_tukar_poin';
	public $incrementing = false;
	public $timestamps = false;
	protected $keyType = 'string';


	protected $casts = [
		'tgl_tukar' => 'datetime',
		'jml' => 'int'
	];

	protected $fillable = [
		'id_tukar_poin',
		'id_pembeli',
		'id_pegawai',
		'id_merch',
		'tgl_tukar',
		'tgl_ambil',
		'jml',
		'status'
	];

	public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
    }

    public function merchandise()
	{
		return $this->belongsTo(Merchandise::class, 'id_merch', 'id_merch');
	}

    public function cs()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
