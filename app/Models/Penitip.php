<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Penitip extends Model
{
    use Notifiable;
    protected $table = 'penitip';
    protected $primaryKey = 'id_penitip';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_penitip', 
        'nama_penitip', 
        'email', 
        'password', 
        'nomor_telepon', 
        'nik_penitip',
        'jenis_kelamin',
        'rating',
        'saldo',
        'tgl_lahir', 
        'id_role',
        'foto_ktp',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_penitip', 'id_penitip');
    }

}