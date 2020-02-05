<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_num');
            $table->string('assigned_to');
            $table->string('case_no')->unique();
            $table->string('case_title');
            $table->string('court');
            $table->string('crime');
            $table->string('detained');
            $table->string('complainant');
            $table->string('respondent');
            $table->string('status');
            $table->string('access_code')->unique();
            $table->string('access_status');
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
        Schema::dropIfExists('cases');
    }
}
