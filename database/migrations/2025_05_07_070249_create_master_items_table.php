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
        Schema::create('master_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_item_id')->nullable();
            $table->string('kode');
            $table->string('nama');
            $table->integer('harga_beli');
            $table->integer('laba');
            $table->string('supplier');
            $table->string('jenis');
            $table->string('foto')->nullable();

            $table->foreign('kategori_item_id')->references('id')->on('kategori_items')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_items');
    }
};
