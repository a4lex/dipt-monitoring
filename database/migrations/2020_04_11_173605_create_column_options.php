<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('represent.table.column_options'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('column_id')->nullable(false);
            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->boolean('editable')->default(0)->nullable(false);
            $table->boolean('visible')->default(0)->nullable(false);

            $table->unique(['column_id', 'role_id']);

            $table->foreign('column_id')
                ->references('id')
                ->on(config('represent.table.columns'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
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
        Schema::dropIfExists(config('represent.table.column_options'));
    }
}
