<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientClassificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_classification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_num');
            $table->string('class')->nullable();
            $table->string('children_in_conflict')->nullable();
            $table->string('indigenous_group')->nullable();
            $table->string('person_with_disability')->nullable();
            $table->string('urban_poor')->nullable();
            $table->string('rural_poor')->nullable();
            $table->string('ofw')->nullable();
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
        Schema::dropIfExists('client_classification');
    }
}
