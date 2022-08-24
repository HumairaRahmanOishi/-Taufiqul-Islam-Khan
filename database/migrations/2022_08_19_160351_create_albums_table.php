<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('genre')->nullable();
            $table->unsignedBigInteger('artistId')->onDelete('cascade');
            $table->date('releaseDate');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes(); 
            $table->timestamps();
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
        Schema::dropIfExists('albums');
    }
}
