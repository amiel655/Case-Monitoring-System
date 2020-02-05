<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalInformationCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_information_case', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_num');
            $table->string('adverse_party');
            $table->string('adverse_party_name');
            $table->string('adverse_party_address');
            $table->text('case_of_action');
            $table->text('fact_of_the_case')->nullable();
            $table->string('pending_in_court')->nullable();
            $table->string('title_of_case')->nullable();
            $table->string('court_body_tribunal')->nullable();
            $table->string('other_case_of_action')->nullable();
            $table->string('other_court_body_tribunal')->nullable();
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
        Schema::dropIfExists('additional_information_case');
    }
}
