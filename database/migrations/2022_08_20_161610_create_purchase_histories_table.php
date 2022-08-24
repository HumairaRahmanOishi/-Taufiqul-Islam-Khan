<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listernerId')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('packageId')->nullable()->onDelete('cascade');
            $table->string('tranxId')->nullable();
            $table->string('bkashNo')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->date('expireDate')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->softDeletes(); 
            $table->timestamps();
            $table->foreign('listernerId')->references('id')->on('listerners');
            $table->foreign('packageId')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_histories');
    }
}
