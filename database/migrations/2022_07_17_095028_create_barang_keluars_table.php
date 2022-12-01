<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('masuk_id');
            $table->foreignId('device_id')->nullable();
            $table->foreignId('penangungJawab_id');
            $table->json('serialNumber')->nullable();
            $table->string('device')->nullable();
            $table->string('merek');
            $table->text('type')->nullable();
            $table->text('pemilik')->nullable();
            $table->integer('unitKeluar');
            $table->string('gambar')->nullable();
            $table->date('tanggalKeluar');

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
        Schema::dropIfExists('barang_keluars');
    }
}
