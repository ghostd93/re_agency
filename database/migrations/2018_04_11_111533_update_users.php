<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->unsignedInteger('personal_data_id')->nullable();
            $table->unsignedInteger('advertisement_id')->nullable();

            $table->foreign('personal_data_id')
                ->references('id')
                ->on('personal_datas');

            $table->foreign('advertisement_id')
                ->references('id')
                ->on('advertisements');
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
