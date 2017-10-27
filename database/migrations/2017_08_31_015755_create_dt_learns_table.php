<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDtLearnsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dt_learns', function (Blueprint $table) {
            // $table->increments('id');
            $table->char('kode', 20)->unique();
            $table->string('nama', 50);
            $table->enum('jk', ['Pria', 'Wanita']);
            $table->char('goldar', 4);
            $table->integer('umur');
            $table->integer('r');
            $table->integer('f');
            $table->integer('m');
            $table->integer('c');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('dt_learns');
    }
}
