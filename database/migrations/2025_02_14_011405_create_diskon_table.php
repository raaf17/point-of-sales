<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiskonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diskon', function (Blueprint $table) {
            $table->id();
            $table->text('tipe_member_id');
            $table->text('kode_diskon');
            $table->text('nama_diskon');
            $table->integer('min_diskon');
            $table->integer('max_diskon');
            $table->integer('diskon');
            $table->date('tgl_mulai');
            $table->date('tgl_berakhir');
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
        Schema::dropIfExists('diskon');
    }
}
