<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdvertisements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->unsignedInteger("user_id")->nullable();
            $table->unsignedInteger("property_id")->nullable();


            $table->foreign("user_id")
                ->references("id")
                ->on("users");

            $table->foreign("property_id")
                ->references("id")
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
        //
    }
}
