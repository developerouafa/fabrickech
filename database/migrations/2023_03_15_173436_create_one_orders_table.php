<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_orders', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('town');
            $table->string('city');
            $table->string('region');
            $table->string('streetaddress');
            $table->string('zipcode');
            $table->string('phone');
            $table->text('products');
            $table->string('quantity');
            $table->string('total');
            $table->bigInteger('statusorder_id' )->unsigned();
            $table->foreign('statusorder_id')->references('id')->on('statusorders')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('one_orders');
    }
};
