<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTypeIfaceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_type_iface_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_type_id')->nullable(false);
            $table->unsignedBigInteger('iface_type_id')->nullable(false);

            $table->unique(['device_type_id', 'iface_type_id'], 'device_iface_type');

            $table->foreign('device_type_id')
                ->references('id')
                ->on('device_types')
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
        Schema::dropIfExists('device_type_iface_types');
    }
}
