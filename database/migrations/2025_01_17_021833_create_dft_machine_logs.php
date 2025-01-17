<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDftMachineLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dft_machine_logs', function (Blueprint $table) {
            $table->id();
            $table->string('machine_ID');
            $table->string('temp');
            $table->string('humid');
            $table->string('weight');
            $table->string('light');
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
        Schema::dropIfExists('dft_machine_logs');
    }
}
