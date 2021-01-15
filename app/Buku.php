<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = ['judul','penulis','penerbit','kategori','gambar','status'];

    public $primaryKey = 'id_buku';
}
