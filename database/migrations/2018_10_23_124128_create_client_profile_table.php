<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_num');
            $table->string('client_name');
            $table->string('client_religion');
            $table->string('client_citizenship');
            $table->text('client_address');
            $table->string('client_email');
            $table->string('client_monthly_income');
            $table->string('detained');
            $table->date('detained_since')->nullable();
            $table->integer('client_age');
            $table->string('client_gender');
            $table->string('client_civil_status');
            $table->string('client_educational_attainment');
            $table->string('client_dialect');
            $table->string('client_contact');
            $table->string('client_spouse')->nullable();
            $table->text('spouse_address')->nullable();
            $table->string('spouse_contact')->nullable();
            $table->text('detention_place')->nullable();
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
        Schema::dropIfExists('client_profile');
    }
}
