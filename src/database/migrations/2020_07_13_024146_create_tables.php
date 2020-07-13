<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue', function (Blueprint $table) {
            $table->id();
            $table->string('command');
            $table->string('submitter_id');
        });
        Schema::create('finished', function (Blueprint $table) {
            $table->id();
            $table->string('command');
            $table->integer('job_id');
            $table->string('submitter_id');
            $table->integer('process_id');
            $table->integer('process_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queue');
        Schema::dropIfExists('finished');
    }
}
