<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printing', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('version_id');
            $table->smallInteger('press_id');
            $table->integer('copy_quantity');
            $table->smallInteger('page_amount');
            $table->smallInteger('plate_stored_at')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('printing');
    }
}