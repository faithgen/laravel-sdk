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
        Schema::create('fg_users', function (Blueprint $table) {
            $table->string('id', 150)->primary();
            $table->string('name');
            $table->string('email', 150)->nullable();
            $table->string('phone', 150)->unique();
            $table->string('provider')->default('faithgen');
            $table->string('password')->default('secret');
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
        Schema::dropIfExists('fg_users');
    }
}
