<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtypeaccTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtypeacc', function (Blueprint $table) {
            $table->increments('id');
            $table->string("ime");
            $table->unsignedInteger("typeid");
            $table->string("link")->unique();
            $table->timestamps();
            $table->string("icon");
        });

        Schema::table("subtypeacc",function (Blueprint $table){
            $table->foreign('typeid')->references("id")->on("typeacc");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtypeacc');
    }
}
