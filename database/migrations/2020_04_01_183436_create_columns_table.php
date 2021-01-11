<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('represent.table.columns'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id')->nullable(false);
            $table->unsignedBigInteger('type_id')->nullable(false);
            $table->string('name', 128)->nullable(false);
            $table->string('alias', 32)->nullable(false);
            $table->string('label', 64)->nullable(false);

//            $table->string('def_value', 128);
            $table->text('popup_values');

            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('singular')->default(false);
            $table->boolean('required')->default(false);

            $table->boolean('orderable')->default(true);
            $table->boolean('searchable')->default(true);
            $table->string('styles', 128)->default('');
            $table->string('rules', 128)->default('');

            $table->unique(['model_id', 'alias']);


            $table->foreign('model_id')
                ->references('id')
                ->on(config('represent.table.models'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on(config('represent.table.column_types'))
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('represent.table.columns'));
    }
}
