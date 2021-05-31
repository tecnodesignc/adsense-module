<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsenseAdsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adsense__ads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('external_image_url')->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->string('target', 10)->nullable();
            $table->integer('space_id')->unsigned();
            $table->foreign('space_id')->references('id')->on('adsense__spaces')->onDelete('cascade');
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
        Schema::drop('adsense__ads');
    }

}
