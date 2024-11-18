<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machine_id');
            $table->string('lat');
            $table->string('lng');
            $table->double('suhu');
            $table->double('kecepatan_angin');
            $table->double('tekanan_udara');
            $table->double('kelembaban');
            $table->boolean('kondisi_baik');
            $table->foreign('machine_id')
                ->references('id')
                ->on('devices');
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
        Schema::dropIfExists('device_logs');
    }
}
