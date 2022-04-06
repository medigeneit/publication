<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('cost_category_id');
            $table->bigInteger('printing_id');
            $table->integer('quantity')->nullable();
            $table->float('rate')->nullable();
            $table->float('amount')->nullable();
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
        Schema::dropIfExists('version_costs');
    }
}
