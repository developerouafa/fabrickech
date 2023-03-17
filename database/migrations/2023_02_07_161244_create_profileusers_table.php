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
        Schema::create('profileusers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('designation');
            $table->string('website');
            $table->string('address');
            $table->string('twitter');
            $table->string('facebook');
            $table->string('google');
            $table->string('linkedin');
            $table->string('github');
            $table->string('biographicalinfo');
            $table->string('fullname');
            $table->string('town');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('streetaddress');
            $table->string('zipcode');
            $table->string('phone');
            $table->bigInteger('user_id' )->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('profileusers');
    }
};
