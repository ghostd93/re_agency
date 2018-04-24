<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string("property_type");
            $table->text("description");
            $table->date("date_of_registration");
            $table->string("property_area");
            $table->date("date_of_construction");
            $table->string("estete_status");
            $table->integer("number_of_floors");
            $table->integer("number_of_rooms");
            $table->integer("floor");
            $table->boolean("balcony");
            $table->boolean("garage");
            $table->string("destiny");
            $table->string("land_area");
            $table->string("management");
            $table->string("country");
            $table->string("city");
            $table->string("street");
            $table->string("street_number");
            $table->string("postal_code");
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
        Schema::dropIfExists('properties');
    }
}
