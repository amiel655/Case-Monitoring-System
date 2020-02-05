<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListDetaineesRepresentedCourtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_detainees_represented_court', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney');
            $table->string('control_num');
            $table->string('item_no')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('place_detention')->nullable();
            $table->string('court')->nullable();
            $table->string('case_no')->nullable();
            $table->string('offense')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('list_detainees_represented_court');
    }
}
