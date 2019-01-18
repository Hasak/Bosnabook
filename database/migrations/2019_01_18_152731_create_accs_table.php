<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();//////////////////////////////////////////
            $table->string("name");
            $table->boolean("izb");
            $table->unsignedInteger("owner")->nullable();
            $table->unsignedInteger("subtype")->nullable();
            $table->unsignedInteger("place")->nullable();
            $table->string("folder");
            $table->unsignedInteger("capacity")->nullable();
            $table->unsignedInteger("minimumNumberOfNights")->nullable();
            $table->unsignedInteger("area")->nullable();
            $table->double("priceJanuary")->nullable();
            $table->double("priceFebruary")->nullable();
            $table->double("priceMarch")->nullable();
            $table->double("priceApril")->nullable();
            $table->double("priceMay")->nullable();
            $table->double("priceJune")->nullable();
            $table->double("priceJuly")->nullable();
            $table->double("priceAugust")->nullable();
            $table->double("priceSeptember")->nullable();
            $table->double("priceOctober")->nullable();
            $table->double("priceNovember")->nullable();
            $table->double("priceDecember")->nullable();
            $table->double("payingAhead")->nullable();
            $table->double("deposit")->nullable();
            $table->unsignedInteger("numberOfFloors")->nullable();
            $table->unsignedInteger("floor")->nullable();
            $table->unsignedInteger("toilet/wc")->nullable();
            $table->unsignedInteger("livingRoom")->nullable();
            $table->unsignedInteger("bedRoom")->nullable();
            $table->unsignedInteger("kitchen")->nullable();
            $table->boolean("multipleInstances")->nullable();
            $table->boolean("breakfast")->nullable();
            $table->boolean("cleaningService")->nullable();
            $table->boolean("laundry")->nullable();
            $table->boolean("iron")->nullable();
            $table->boolean("ironing")->nullable();
            $table->boolean("internet")->nullable();
            $table->boolean("airCondition")->nullable();
            $table->boolean("heating")->nullable();
            $table->boolean("terrace/balcony")->nullable();
            $table->boolean("garden")->nullable();
            $table->boolean("garage/parking")->nullable();
            $table->boolean("pool")->nullable();
            $table->boolean("barbecue")->nullable();
            $table->boolean("alarm")->nullable();
            $table->boolean("videoSurveillance")->nullable();
        });
        Schema::table("accs",function (Blueprint $table){
            $table->foreign("owner")->references('id')->on("users")->onDelete("set null");
            $table->foreign("place")->references("id")->on("subplaces")->onDelete("set null");
            $table->foreign("subtype")->references("id")->on("subtypeacc")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accs');
    }
}
