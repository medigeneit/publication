<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenesisCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genesis_customer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no');
            $table->unsignedBigInteger('customer_id')->index();
            $table->bigInteger('course_id')->nullable();
            $table->string('course_name')->nullable();
            $table->bigInteger('batch_id')->nullable();
            $table->string('batch_name')->nullable();
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
        Schema::dropIfExists('genesis_customer_infos');
    }
}
