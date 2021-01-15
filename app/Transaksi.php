<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['id_peminjam','id_buku','komentar','tanggal_pinjam','tanggal_kembali','jumlah_denda','id_verifikator'];

    public $primaryKey = 'id_transaksi';
}
