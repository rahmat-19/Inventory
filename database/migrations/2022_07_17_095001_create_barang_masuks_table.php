<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('penangungJawab_id');
            $table->foreignId('device_id')->nullable();
            $table->json('serialNumber')->nullable();
            $table->string('pemilik')->nullable();
            $table->string('device')->nullable();
            $table->integer('unit');
            $table->string('merek');
            $table->text('type')->nullable();
            $table->string('gambar')->nullable();
            $table->date('tanggalMasuk');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuks');
    }
}
