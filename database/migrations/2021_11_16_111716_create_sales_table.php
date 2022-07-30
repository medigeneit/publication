<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            // $table->string('name')->nullable();
            // $table->string('address')->nullable();
            // $table->bigInteger('phone')->unique();
            // $table->string('email')->nullable();
            // $table->tinyInteger('price_type')->nullable()->comment('1= Retail, 2 = Client, 3 = Wholesale, 4 =Special');
            // $table->float('subtotal')->nullable();
            $table->float('discount')->nullable();
            $table->text('discount_purpose')->nullable();
            // $table->float('due')->nullable();
            // $table->text('due_condition')->nullable();
            $table->float('payable')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->tinyInteger('memo_type')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
