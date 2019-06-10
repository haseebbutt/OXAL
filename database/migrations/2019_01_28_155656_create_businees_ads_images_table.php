<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusineesAdsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_ads_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_ad_id')->default(0);
            $table->string('name')->nullable();
            $table->string('name_without_ext')->nullable();
            $table->string('ext')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_ads_images');
    }
}
