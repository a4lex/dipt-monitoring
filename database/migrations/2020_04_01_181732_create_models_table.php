<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('represent.table.models'), function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique()->nullable(false);
            $table->string('label', 64)->nullable(false);
            $table->string('ref_table', 32)->nullable(false);
            $table->string('alias', 16)->nullable(false);
            $table->string('col_id', 32)->nullable(false);
            $table->string('col_val', 32)->nullable(false);
            $table->string('model', 64)->nullable(false);
            $table->string('controller', 64)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('represent.table.models'));
    }
}
