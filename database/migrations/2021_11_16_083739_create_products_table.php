<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->float('production_cost')->nullable();
            $table->float('mrp')->nullable();
            $table->float('wholesale_rate')->nullable();
            $table->float('retail_rate')->nullable();
            $table->tinyInteger('alert_quantity')->nullable();
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
