<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceInitVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('init_variables', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('device_type_id')->nullable(false);
            $table->enum('name', ['name', 'location', 'firmware', 'mac', 'model', ])
                ->nullable(false)->default('name');
            $table->string('query', 255)->nullable(false);

            $table->timestamps();

            $table->unique(['device_type_id', 'name']);

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
        Schema::dropIfExists('init_variables');
    }
}
