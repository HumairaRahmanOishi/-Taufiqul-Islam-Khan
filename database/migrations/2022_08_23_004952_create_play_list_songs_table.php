<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayListSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_list_songs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlistId')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('songId')->nullable()->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes(); 
            $table->timestamps();
            $table->foreign('songId')->references('id')->on('songs');
            $table->foreign('playlistId')->references('id')->on('playlists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('play_list_songs');
    }
}
