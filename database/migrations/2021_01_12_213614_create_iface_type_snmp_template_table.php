<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIfaceTypeSnmpTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iface_type_snmp_template', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dev_iface_type_id')->nullable(false);
            $table->unsignedBigInteger('snmp_template_id')->nullable(false);

            $table->unique(['dev_iface_type_id', 'snmp_template_id'], 'dev_iface_id_type_snmp_id');

            $table->foreign('dev_iface_type_id')
                ->references('id')
                ->on('device_type_iface_types')
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
        Schema::dropIfExists('iface_type_snmp_template');
    }
}
