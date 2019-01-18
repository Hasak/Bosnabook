<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rented', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger("carid");
            $table->date("od");
            $table->date("do");
            $table->string("gname")->default("");
            $table->string("gsurname")->default("");
            $table->double("cijena")->default(0);
            $table->string("tel")->default("");
            $table->string("email")->default("");
            $table->unsignedInteger("userid")->nullable();
            $table->unsignedInteger("drzave")->nullable();
            $table->string("dob")->default("");
            $table->boolean("airport")->default(0);
            $table->string("idslik")->nullable();
            $table->string("licslik")->nullable();
            $table->string("ppslik")->nullable();
            $table->boolean("gps")->default(false);
            $table->boolean("picnic")->default(false);
            $table->boolean("cseat")->default(false);
            $table->string("cc")->default("");
            $table->unsignedInteger("expm")->default(0);
            $table->unsignedInteger("expg")->default(0);
            $table->unsignedInteger("cvv")->default(0);
            $table->text("notes")->nullable();
            $table->boolean("prihvaceno")->default(false);
            $table->boolean("izbrisano")->default(false);
            $table->string("ccode")->unique();
            $table->string("hashh")->unique();
        });

        Schema::table('rented', function (Blueprint $table) {
            $table->foreign("carid")->references("id")->on("auta");
            $table->foreign("userid")->references("id")->on("users");
            $table->foreign("drzave")->references("id")->on("drzave");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rented');
    }
}
