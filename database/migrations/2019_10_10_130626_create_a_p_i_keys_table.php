<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAPIKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fg_a_p_i_keys', function (Blueprint $table) {
            $table->string('id');
            $table->string('ministry_id', 150)->unique()->index();
            $table->string('api_key')->unique();
            $table->timestamps();

            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fg_a_p_i_keys');
    }
}
