<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auta', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("name");
            $table->unsignedInteger("owner")->nullable();
            $table->unsignedInteger("type")->nullable();
            $table->double("cijena");
            $table->double("cijena2");
            $table->double("cijena3");
            $table->double("cijena4");
            $table->double("cijena5");
            $table->double("cijena6");
            $table->double("cijena7");
            $table->double("cijena8");
            $table->boolean("izbrisano");
            $table->unsignedInteger("gorivo")->nullable();
            $table->boolean("automatik");
            $table->boolean('klima');
            $table->unsignedInteger('brsjedista');
            $table->unsignedInteger('kofkap');
            $table->unsignedInteger('godine');
        });

        Schema::table('auta', function (Blueprint $table) {
            $table->foreign('owner')->references('id')->on('users')->onDelete("set null");
            $table->foreign('type')->references('id')->on('autatypes')->onDelete("set null");
            $table->foreign('gorivo')->references('id')->on('goriva')->onDelete("set null");
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auta');
    }
}
