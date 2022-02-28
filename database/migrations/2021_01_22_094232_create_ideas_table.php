<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('address');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('status')->default(1);
            $table->string('title');
            $table->string('logo');
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
        Schema::drop('ideas');
    }
}
