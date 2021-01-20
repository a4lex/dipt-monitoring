<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceIfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_ifaces', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('device_id')->nullable(false);
            $table->unsignedBigInteger('iface_type_id')->nullable(false);
            $table->unsignedInteger('oid')->nullable(false);
            $table->unsignedInteger('speed')->default(0);
            $table->string('name', 128)->default('');
            $table->string('description', 256)->default('');

            $table->timestamps();

            $table->unique(['device_id', 'oid']);

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('iface_type_id')
                ->references('id')
                ->on('iface_types')
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
        Schema::dropIfExists('device_ifaces');
    }
}
