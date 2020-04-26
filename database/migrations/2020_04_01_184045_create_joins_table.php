<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('represent.table.joins'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id')->nullable(false);
            $table->enum('type', ['inner', 'left', 'right'])->nullable(false)->default('inner');
            $table->string('ref_table', 32)->nullable(false);
            $table->string('alias', 16)->nullable(false);
            $table->string('col_a', 32)->nullable(false);
            $table->string('col_b', 32)->nullable(false);
            $table->string('mode', 16)->nullable(false);

            $table->foreign('model_id')
                ->references('id')
                ->on(config('represent.table.models'))
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
        Schema::dropIfExists(config('represent.table.joins'));
    }
}
