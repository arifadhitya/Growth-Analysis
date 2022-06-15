<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analises', function (Blueprint $table) {
            $table->id();
            $table->string('kodetransaksi');
            $table->string('totalbayar');
            $table->date('tanggaltransaksi');
            $table->string('kodeproduk');
            $table->string('jumlahproduk');
            $table->timestamps();

            $table->foreign('kodetransaksi')->references('kodetransaksi')->on('transaksis');
            $table->foreign('kodeproduk')->references('kodeproduk')->on('produks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analises');
    }
};
