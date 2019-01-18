<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger("accid");
            $table->date("od");
            $table->date("do");
            $table->string("gname")->default("");
            $table->string("gsurname")->default("");
            $table->double("cijena")->default(0);
            $table->string("tel")->default("");
            $table->string("email")->default("");
            $table->unsignedInteger("userid")->nullable();
            $table->unsignedInteger("drzave")->nullable();
            $table->unsignedInteger("adults")->default(0);
            $table->unsignedInteger("children")->default(0);
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

        Schema::table('reserved', function (Blueprint $table) {
            $table->foreign("accid")->references("id")->on("accs");
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
        Schema::dropIfExists('reserved');
    }
}
