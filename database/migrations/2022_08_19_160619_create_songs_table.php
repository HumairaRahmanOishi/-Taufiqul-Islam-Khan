<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('length')->nullable();
            $table->string('musicUrl')->nullable();
            $table->unsignedBigInteger('albumId')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('artistId')->nullable()->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes(); 
            $table->timestamps();
            $table->foreign('albumId')->references('id')->on('albums');
            $table->foreign('artistId')->references('id')->on('artists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
