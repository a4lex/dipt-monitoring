<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtIfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_ifaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id')->nullable(false);

            $table->string('name', 32);
            $table->string('radio_name', 64)->unique(true);
            $table->string('mode', 32)->default('station');

            $table->string('frequency', 16);
            $table->string('ch_width', 32);
            $table->char('mac', 17)->default('00:00:00:00:00:00');

            $table->double('height')->default(0);
            $table->unsignedSmallInteger('azimuth')->default(0);

            $table->timestamps();

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mt_ifaces');
    }
}
