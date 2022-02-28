<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas_img',function (Blueprint $table){
           $table->bigIncrements('id');
           $table->bigInteger('ideas_id')->unsigned();
           $table->foreign('ideas_id')->references('id')->on('ideas');
           $table->string('path');
           $table->integer('status')->default(1);
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
        //
    }
}
