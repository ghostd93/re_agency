<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->string("status");
            $table->string("type");
            $table->date("date_of_announcement");
            $table->string("description");
            $table->integer("price");
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("property_id");
            $table->timestamps();


            $table->foreign("user_id")
                ->references("user_id")
                ->on("users");

            $table->foreign("property_id")
                ->references("property_id")
                ->on("properties");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
