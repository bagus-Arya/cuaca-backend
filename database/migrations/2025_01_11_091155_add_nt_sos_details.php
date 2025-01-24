<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNtSosDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // sos button from handphone
        Schema::create('add_nt_sos_details', function (Blueprint $table) {
            $table->id();
            $table->string('lat');
            $table->string('lng');
            $table->unsignedBigInteger('group_staff_fishermans_id');
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
        Schema::dropIfExists('add_nt_sos_details');
    }
}
