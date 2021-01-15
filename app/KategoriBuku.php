<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $fillable = ['nama'];

    public $primaryKey = 'id_kategori';
}
