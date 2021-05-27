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
            $table->text('x'); //string, not float, because encrypted and serialized
            $table->text('y');
            $table->text('ip');
            $table->integer('type'); // txt img aud vid
            $table->longText('content');
            $table->float('fade_rate', 3, 2);
            $table->integer('score');
            $table->integer('reports')->default(0); //should this actually be stored in the database? or should it be calculated on retrieval?
            
            $table->integer('p_id')->unsigned()->nullable()->default(null); //parent id
            $table->foreign('p_id')->references('id')->on('croaks')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
