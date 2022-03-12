<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sale_id');
            $table->string('transaction')->nullable();
            $table->double('amount');
            $table->tinyInteger('status')->comment("1=complete, 0=incomplete");
            $table->tinyInteger('payment_type')->comment("1=Cash, 2=SSLCommerze");
            $table->string('due_condition')->nullable();
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
        Schema::dropIfExists('payment');
    }
}
