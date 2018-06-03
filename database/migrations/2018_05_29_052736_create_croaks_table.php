<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCroaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('croaks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('x');
            $table->integer('y');
            $table->ipAddress('ip');
            $table->integer('type'); // txt img aud vid
            $table->string('content');
            $table->float('fade_rate', 3, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('croaks');
    }
}
