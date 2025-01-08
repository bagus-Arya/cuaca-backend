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
        Schema::create('nt_sos_logs', function (Blueprint $table) {
            $table->id();
            $table->string('lat');
            $table->string('lng');
            $table->unsignedBigInteger('group_staff_fishermans_id');
            $table->unsignedBigInteger('host_id');
            $table->foreign('host_id')
            ->references('id')
            ->on('nt_machine_logs');
            $table->foreign('group_staff_fishermans_id')
            ->references('id')
            ->on('group_staff_fishermans');
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
