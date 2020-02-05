<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHearingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hearing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('case_no');
            $table->string('case_status');
            $table->longText('hearing_date')->nullable();
            $table->string('case_summary')->nullable();
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
        Schema::dropIfExists('hearing');
    }
}
