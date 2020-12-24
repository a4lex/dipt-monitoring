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
            $table->enum('source', ['snmp', 'mysql', 'system'])
                ->nullable(false)->default('snmp');
            $table->string('query', 255)->nullable(false);
            $table->string('shared', 32)->nullable(false);
            $table->string('vlabel', 32)->nullable(false);
            $table->integer('rate');
            $table->enum('type', ['GAUGE','COUNTER','DERIVE','ABSOLUTE','COMPUTE'])
                ->nullable(false)->default('COUNTER');
            $table->bigInteger('min')->default(0);
            $table->bigInteger('max')->default(100);
            $table->bigInteger('threshold')->default(1000000);
            $table->string('color', 16)->nullable(false)->default('#2000AFAF');
            $table->string('line', 16)->nullable(false)->default('LINE1');
            $table->string('format', 32)->nullable(false)->default('%2.4lf');
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
