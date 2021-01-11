<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnmpTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snmp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->nullable(false);
            $table->string('pname', 32)->nullable(false);
            $table->enum('source', ['snmp', 'mysql', 'system'])
                ->nullable(false)->default('snmp');
            $table->string('query', 255)->nullable(false);
            $table->string('shared', 32)->nullable(false);
            $table->string('vlabel', 32)->nullable(false);
            $table->integer('rate');
            $table->enum('type', ['GAUGE','COUNTER','DERIVE','ABSOLUTE','COMPUTE'])
                ->nullable(false)->default('COUNTER');
            $table->unsignedSmallInteger('step')->default(300);
            $table->bigInteger('min')->default(0);
            $table->bigInteger('max')->default(100);
            $table->bigInteger('threshold')->default(1000000);
            $table->string('color', 16)->nullable(false)->default('#2000AF');
            $table->boolean('fill_bg')->default(0)->nullable(false);

            $table->timestamps();

            $table->unique(['name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snmp_templates');
    }
}
