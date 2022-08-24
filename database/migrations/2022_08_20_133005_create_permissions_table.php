<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('roleId')->nullable()->onDelete('cascade');
            $table->string('permissionName')->nullable();
            $table->integer('permissionCode')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=Active,0=Inactive');
            $table->softDeletes(); 
            $table->timestamps();
            $table->foreign('roleId')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
