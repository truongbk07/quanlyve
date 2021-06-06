<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tens', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
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
        Schema::dropIfExists('tens');
    }
}
