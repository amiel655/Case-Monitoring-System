<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListFavorableDecisionDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_favorable_decision_disposition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney');
            $table->string('control_num');
            $table->string('name_client')->nullable();
            $table->string('case_title')->nullable();
            $table->string('docket_no')->nullable();
            $table->string('place_detention')->nullable();
            $table->string('court')->nullable();
            $table->string('nature_case')->nullable();
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
        Schema::dropIfExists('list_favorable_decision_disposition');
    }
}
