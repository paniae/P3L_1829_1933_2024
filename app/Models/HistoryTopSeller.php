<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryTopSeller
 * 
 * @property string $id_history_top_seller
 * @property string $id_penitip
 * @property Carbon $periode
 * 
 * @property Penitip $penitip
 *
 * @package App\Models
 */
class HistoryTopSeller extends Model
{
	protected $table = 'history_top_seller';
	protected $primaryKey = 'id_history_top_seller';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'periode' => 'datetime'
	];

	protected $fillable = [
		'id_penitip',
		'periode'
	];

	public function penitip()
	{
		return $this->belongsTo(Penitip::class, 'id_penitip');
	}
}
