<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listernerId')->nullable()->onDelete('cascade');
            $table->tinyInteger('isSuffle')->default(1);
            $table->tinyInteger('isRepeat')->default(1)->comment('1=repeat 1,2=repeat all,3=just play current play list');
            $table->softDeletes(); 
            $table->timestamps();
            $table->foreign('listernerId')->references('id')->on('listerners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_settings');
    }
}
