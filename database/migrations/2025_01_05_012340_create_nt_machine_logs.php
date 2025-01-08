<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNtMachineLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nt_machine_logs', function (Blueprint $table) {
            $table->id();
            $table->string('host_id');
            $table->string('lat');
            $table->string('lng');
            $table->float('temp');
            $table->float('humidity');
            $table->smallInteger('pressure');
            $table->softDeletes();
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
        Schema::dropIfExists('nt_machine_logs');
    }
}
