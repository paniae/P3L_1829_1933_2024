<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Pembeli extends Model
{
    use Notifiable;
    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pembeli',
        'nama_pembeli',
        'email',
        'password',
        'nomor_telepon',
        'jenis_kelamin',
        'tgl_lahir',
        'id_role',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_pembeli', 'id_pembeli');
    }

    public function alamat()
    {
        return $this->hasOne(Alamat::class, 'id_pembeli', 'id_pembeli')->where('default_alamat', true);
    }

}
