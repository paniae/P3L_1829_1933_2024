<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
    ];

    public $timestamps = true;
}