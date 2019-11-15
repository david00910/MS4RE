<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyHasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_has_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('prop_id')->unsigned();
            $table->bigInteger('cat_id')->unsigned();
            $table->timestamps();

            $table->foreign('prop_id')->references('id')->on('properties');
            $table->foreign('cat_id')->references('id')->on('property_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_has_categories');
    }
}
