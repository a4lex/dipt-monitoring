<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('represent.table.actions'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id')->nullable(false);
            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->enum('name', ['create', 'view', 'edit', 'delete'])->nullable(false);
            $table->boolean('state')->default(false)->nullable(false);

            $table->unique(['model_id', 'role_id', 'name']);

            $table->foreign('model_id')
                ->references('id')
                ->on(config('represent.table.models'))
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
        Schema::dropIfExists(config('represent.table.actions'));
    }
}
