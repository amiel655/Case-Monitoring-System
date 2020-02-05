<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualReportCiclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_report_cicl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('section')->nullable();
            $table->text('key_indicators_of_performance')->nullable();
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
        Schema::dropIfExists('individual_report_cicl');
    }
}
