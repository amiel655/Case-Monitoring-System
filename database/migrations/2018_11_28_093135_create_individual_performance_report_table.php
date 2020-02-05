<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualPerformanceReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_performance_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney')->nullable();
            $table->string('section')->nullable();
            $table->string('key_indicators_of_performance')->nullable();
            $table->string('total')->nullable();
            $table->string('cr')->nullable();
            $table->string('cv')->nullable();
            $table->string('adm1')->nullable();
            $table->string('adm2')->nullable();
            $table->string('adm3')->nullable();
            $table->string('report_month');
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
        Schema::dropIfExists('individual_performance_report');
    }
}
