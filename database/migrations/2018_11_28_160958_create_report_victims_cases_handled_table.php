<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportVictimsCasesHandledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_victims_cases_handled', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney');
            $table->string('control_num');
            $table->integer('item_no')->nullable();
            $table->string('nature_client')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('action_taken')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('report_victims_cases_handled');
    }
}
