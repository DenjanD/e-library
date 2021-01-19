<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->bigIncrements('id_buku');
            $table->string('judul',40);
            $table->string('penulis',40);
            $table->string('penerbit',40);
            $table->bigInteger('kategori')->unsigned();
            $table->text('sinopsis');
            $table->enum('status', ['T','D','K']);
            $table->string('gambar',50);
            $table->timestamps();

            $table->foreign('kategori')->references('id_kategori')->on('kategori_bukus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukus');
    }
}
