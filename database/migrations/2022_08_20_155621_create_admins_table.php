<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email',228)->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('password');
            $table->unsignedBigInteger('role')->default(1)->onDelete('cascade');
            $table->string('avatar',1000)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=Active,2=Inactive,0=Deleted');
            $table->rememberToken();
            $table->softDeletes(); 
            $table->timestamps();
            $table->foreign('role')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
