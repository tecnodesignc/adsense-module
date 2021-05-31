<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsenseAdTranslationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adsense__ad_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('ad_id')->unsigned();
            $table->text('custom_html')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('uri')->nullable();
            $table->boolean('active')->default(false);
            $table->string('locale')->index();
            $table->unique(['ad_id', 'locale']);
            $table->foreign('ad_id')->references('id')->on('adsense__ads')->onDelete('cascade');
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
        Schema::drop('adsense__ad_translations');
    }

}
