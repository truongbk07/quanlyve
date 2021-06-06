<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHanhTrinhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hanh_trinhs', function (Blueprint $table) {
            $table->id();
            $table->string('chuyenbay');
            $table->string('ngaybay');
            $table->string('giobay');
            $table->string('noidi');
            $table->string('gioden');
            $table->string('noiden');
            $table->bigInteger('macode_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('macode_id')->references('id')->on('ma_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hanh_trinhs');
    }
}
