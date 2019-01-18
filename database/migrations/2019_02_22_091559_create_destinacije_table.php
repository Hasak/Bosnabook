<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinacijeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinacije', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("ime");
            $table->text("stext");
            $table->text("text");
            $table->string("folder");
            $table->unsignedInteger("place");
            $table->boolean("poc");
        });

        Schema::table("destinacije",function (Blueprint $table){
            $table->foreign("place")->references("id")->on("subplaces");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinacije');
    }
}
