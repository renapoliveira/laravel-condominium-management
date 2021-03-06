<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');            
            $table->string('login')->unique();
            $table->string('password');
            $table->integer('profile_id')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('unit')->nullable()->default(null);
            $table->integer('floor')->nullable()->default(null);
            $table->integer('apartment')->nullable()->default(null);
            $table->boolean('soft_delete')->default(0);
            $table->rememberToken();
            $table->timestamps();
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
