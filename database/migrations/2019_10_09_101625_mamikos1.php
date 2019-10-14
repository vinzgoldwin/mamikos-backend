<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mamikos1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('status');
            $table->unsignedInteger('credit');
            $table->timestamps();
        });


        Schema::create('owners', function (Blueprint $table) {
            $table->increments('owner_id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });


        Schema::create('kosts', function (Blueprint $table) {
            $table->increments('kost_id');
            $table->unsignedInteger('owner_id');
            $table->string('kost_name');
            $table->integer('avail_room_count');
            $table->text('address');
            $table->text('description');
            $table->string('city');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('owner_id')->references('owner_id')->on('owners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
