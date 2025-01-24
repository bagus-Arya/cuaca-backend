<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNtSosLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // sos button from arduino
        Schema::create('nt_sos_logs', function (Blueprint $table) {
            $table->id();
            $table->string('lat');
            $table->string('lng');
            $table->unsignedBigInteger('host_id');
            $table->foreign('host_id')
            ->references('id')
            ->on('nt_devices_list');
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
        Schema::dropIfExists('nt_sos_logs');
    }
}
