<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentNotarizedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_notarized', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attorney');
            $table->string('control_num');
            $table->string('date')->nullable();
            $table->string('nature_instrument')->nullable();
            $table->string('executor')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('witnesses')->nullable();
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
        Schema::dropIfExists('document_notarized');
    }
}
