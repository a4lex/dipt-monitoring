<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTypeSnmpTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_type_snmp_template', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_type_id')->nullable(false);
            $table->unsignedBigInteger('snmp_template_id')->nullable(false);

            $table->foreign('device_type_id')
                ->references('id')
                ->on('device_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('snmp_template_id')
                ->references('id')
                ->on('snmp_templates')
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
        Schema::dropIfExists('device_type_snmp_template');
    }
}
