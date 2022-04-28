<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1=Package, 2=Book, 3=Lecture Sheet');
            $table->unsignedBigInteger('production_id')->nullable();
            $table->string('edition');
            $table->timestamp('release_date')->nullable();
            $table->string('isbn')->nullable();
            $table->string('crl')->nullable();
            $table->string('link')->nullable();
            $table->double('production_cost')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('active')->default(1);
            $table->integer('alert_quantity')->default(0);
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
        Schema::dropIfExists('versions');
    }
}
