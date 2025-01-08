<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNtMachineStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nt_machine_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('group_staff_fishermans_id');
            $table->foreign('group_staff_fishermans_id')
            ->references('id')
            ->on('group_staff_fishermans');
            $table->foreign('host_id')
            ->references('id')
            ->on('nt_machine_logs');
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
        Schema::dropIfExists('nt_machine_staff');
    }
}
