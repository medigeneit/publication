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
            $table->float('wholesale_price')->nullable();
            $table->float('retail_price')->nullable();
            $table->float('distribute_price')->nullable();
            $table->float('special_price')->nullable();
            $table->float('outside_dhaka_price')->nullable();
            $table->float('ecom_distribute_price')->nullable();
            $table->float('ecom_wholesale_price')->nullable();
            $table->string('edition')->nullable();
            $table->string('isbn')->nullable();
            $table->string('crl')->nullable();
            $table->unsignedBigInteger('alert_quantity')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->unsignedBigInteger('user_id');
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
