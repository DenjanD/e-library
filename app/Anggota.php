<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['username', 'password', 'nama_anggota', 'telp', 'alamat', 'jenis_kelamin', 'tgl_lahir', 'email', 'foto'];

    public $primaryKey = 'id_anggota';
}
