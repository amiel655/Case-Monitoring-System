<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyInventoryCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_inventory_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney');
            $table->string('control_num');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('cicl')->nullable();
            $table->string('women')->nullable();
            $table->string('indigenous_group')->nullable();
            $table->string('pwd')->nullable();
            $table->string('urban')->nullable();
            $table->string('rural')->nullable();
            $table->string('senior')->nullable();
            $table->string('ofw')->nullable();
            $table->string('judicial')->nullable();
            $table->string('quasi_judicial')->nullable();
            $table->string('non_judicial')->nullable();
            $table->string('action_taken')->nullable();
            $table->string('title_of_the_case')->nullable();
            $table->string('case_no')->nullable();
            $table->string('case_status')->nullable();
            $table->string('nature_case')->nullable();
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
        Schema::dropIfExists('monthly_inventory_cases');
    }
}
