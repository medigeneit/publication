<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('type')->default(2)->comment('1=Admin, 2=User');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            // $table->unsignedBigInteger('outlet_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('user_id')->default(0)->comment('0=Register, user_id=created_by');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
