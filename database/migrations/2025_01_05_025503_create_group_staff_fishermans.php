<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupStaffFishermans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_staff_fishermans', function (Blueprint $table) {
            $table->id();
            $table->string('staff_nm');
            $table->string('email');
            $table->string('addr');
            $table->string('no_hp',15)->nullable();
            $table->enum('role', ['ketua', 'anggota', 'pic']);
            $table->string('password');
            $table->unsignedBigInteger('group_fishermans_id');
            $table->foreign('group_fishermans_id')
            ->references('id')
            ->on('group_fishermans');
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
        Schema::dropIfExists('group_staff_fishermans');
    }
}
