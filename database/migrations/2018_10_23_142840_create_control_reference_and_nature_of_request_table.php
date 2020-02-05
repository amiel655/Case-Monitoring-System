<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlReferenceAndNatureOfRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_reference_and_nature_of_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_num');
            $table->string('interviewer');
            $table->string('assigned_to');
            $table->string('referred_by');
            $table->string('refer_to');
            $table->string('nature_request');
            $table->string('status');
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
        Schema::dropIfExists('control_reference_and_nature_of_request');
    }
}
