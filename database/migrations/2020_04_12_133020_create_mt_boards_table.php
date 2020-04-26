<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_boards', function (Blueprint $table) {
            $table->id();

            $table->string('name', 32)->unique(true);
            $table->unsignedInteger('last_ip')->nullable(false);

            $table->string('username', 32)->default('admin');
            $table->string('password', 32)->default('');
            $table->string('community', 32)->default('');

            $table->string('location1', 255)->default('');
            $table->string('location2', 255)->default('');
            $table->float('lat', 9,6)->default(0.0);
            $table->float('lon', 9,6)->default(0.0);

            $table->string('sn', 64)->default('');
            $table->string('model', 64)->default('');
            $table->string('version', 32)->default('');
            $table->string('firmware', 32)->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mt_boards');
    }
}
