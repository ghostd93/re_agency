<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("surename");
            $table->string("phone_number");
            $table->string("country");
            $table->string("city");
            $table->string("street");
            $table->string("street_number");
            $table->string("postal_code");
            $table->unsignedInteger("user_id");
            $table->timestamps();


            $table->foreign("user_id")
                ->references("user_id")
                ->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_datas');
    }
}
