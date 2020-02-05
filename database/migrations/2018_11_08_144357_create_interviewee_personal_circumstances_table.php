<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntervieweePersonalCircumstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviewee_personal_circumstances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_num');
            $table->string('interviewee_name')->nullable();
            $table->text('interviewee_address')->nullable();
            $table->text('interviewee_relationship_to_client')->nullable();
            $table->integer('interviewee_age')->nullable();
            $table->string('interviewee_gender')->nullable();
            $table->string('interviewee_civil_status')->nullable();
            $table->string('interviewee_contact')->nullable();
            $table->string('interviewee_email')->nullable();
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
        Schema::dropIfExists('interviewee_personal_circumstances');
    }
}
