<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->bigInteger('id_peminjam')->unsigned();
            $table->bigInteger('id_buku')->unsigned();
            $table->text('komentar')->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->integer('jumlah_denda');
            $table->char('id_verifikator',5)->nullable();
            $table->timestamps();

            $table->foreign('id_peminjam')->references('id_anggota')->on('anggotas');
            $table->foreign('id_buku')->references('id_buku')->on('bukus');
            $table->foreign('id_verifikator')->references('id_admin')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
