<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('filename')->unique();
            $table->string('path')->unique();
            $table->integer('filesize');
        });

        Schema::create('croak_file', function (Blueprint $table){
            $table->integer('croak_id')->unsigned()->index();
            $table->foreign('croak_id')->references('id')->on('croaks')->onDelete('cascade');
            $table->integer('file_id')->unsigned()->index()->nullable();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('croak_file');
    }
}
