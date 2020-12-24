<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_links', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mt_iface1_id');
            $table->unsignedBigInteger('mt_iface2_id');

            // tx values
            $table->smallInteger('s1')->nullable(true);
            $table->smallInteger('s1_ch0')->nullable(true);
            $table->smallInteger('s1_ch1')->nullable(true);
            $table->smallInteger('ccq1')->nullable(true);
            $table->smallInteger('rate1')->nullable(true);
            $table->unsignedInteger('prev_byte1')->nullable(false)->default(0);
            $table->unsignedInteger('diff_byte1')->nullable(false)->default(0);

            // rx values
            $table->smallInteger('s2')->nullable(true);
            $table->smallInteger('s2_ch0')->nullable(true);
            $table->smallInteger('s2_ch1')->nullable(true);
            $table->smallInteger('ccq2')->nullable(true);
            $table->smallInteger('rate2')->nullable(true);
            $table->unsignedInteger('prev_byte2')->nullable(false)->default(0);
            $table->unsignedInteger('diff_byte2')->nullable(false)->default(0);

            $table->timestamps();

            $table->unique(['mt_iface1_id', 'mt_iface2_id']);

            $table->foreign('mt_iface1_id')
                ->references('id')
                ->on('mt_ifaces')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('mt_iface2_id')
                ->references('id')
                ->on('mt_ifaces')
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
        Schema::dropIfExists('mt_links');
    }
}
