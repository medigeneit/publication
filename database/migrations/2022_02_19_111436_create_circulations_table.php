<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCirculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circulations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('circulation_id')->nullable();
            $table->bigInteger('storage_id');
            $table->morphs('destinationable');
            $table->integer('quantity')->comment('[positive => in-stock,negetive => out-stock]');
            $table->morphs('requestable');
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
        Schema::dropIfExists('circulations');
    }
}
