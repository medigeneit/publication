<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
<<<<<<< HEAD:database/migrations/2022_04_28_072846_create_product_requests_table.php
            $table->unsignedBigInteger('outlet_id')->nullable();
            $table->date('expected_date');
            $table->integer('user_id')->nullable();
=======
            $table->integer('storage_id');
            $table->date('expected_date');
            $table->unsignedBigInteger('user_id');
>>>>>>> 4b2ccc933da6ab88e83396b6e8cfc28b38b0aac5:database/migrations/2022_04_06_063032_create_product_requests_table.php
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
        Schema::dropIfExists('product_requests');
    }
}
