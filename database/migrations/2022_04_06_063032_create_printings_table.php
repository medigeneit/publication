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
        Schema::create('printings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('version_id');
            $table->smallInteger('press_id');
            $table->integer('copy_quantity');
            $table->integer('received_quantity')->default(0);
            $table->smallInteger('page_amount');
            $table->double('others_cost')->default(0);
            $table->double('cost_per_unit')->nullable();
            $table->smallInteger('plate_stored_at')->nullable();
            $table->smallInteger('binding_type_id')->nullable();
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
        Schema::dropIfExists('printings');
    }
}
