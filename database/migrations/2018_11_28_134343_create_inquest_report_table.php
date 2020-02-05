<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquestReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquest_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney')->nullable();
            $table->string('control_num');
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('legal_advice')->nullable();
            $table->string('custodial')->nullable();
            $table->string('precint')->nullable();
            $table->string('subject')->nullable();
            $table->string('time_call')->nullable();
            $table->string('time_attend')->nullable();
            $table->string('report_month')->nullable();
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
        Schema::dropIfExists('inquest_report');
    }
}
