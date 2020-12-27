<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('device_type_id')->nullable(false);
            $table->string('name', 64)->unique(true);
            $table->unsignedInteger('ip')->nullable(false)->unique(true);

            $table->string('username', 32)->default('admin');
            $table->string('password', 32)->default('');
            $table->string('community', 32)->default('');

            $table->string('mac', 17)->default('00:00:00:00:00:00');
            $table->string('model', 64)->default('unknown');
            $table->string('firmware', 32)->default('unknown');
            $table->string('location', 255)->default('unknown');

            $table->timestamps();

            $table->foreign('device_type_id')
                ->references('id')
                ->on('device_types')
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
        Schema::dropIfExists('devices');
    }
}
