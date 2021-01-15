<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['id_admin','nama_admin','password'];

    public $primaryKey = 'id_admin';
    public $incrementing = false;
}
