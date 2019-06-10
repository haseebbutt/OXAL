<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('title')->nullable();
            $table->string('condition')->nullable();
            $table->longText('description')->nullable();
            $table->integer('price')->default(0);
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->float('longitude', 8, 6)->default(0);
            $table->float('laptitude', 8, 6)->default(0);
            $table->tinyInteger('featured')->default(0)->comment('0 for not featured, 1 for featured');
            $table->tinyInteger('sold')->default(0)->comment('0 for not sold, 1 for sold');;
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
        Schema::dropIfExists('products');
    }
}
