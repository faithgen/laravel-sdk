<?php

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_services', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('ministry_id', 150)->index();
            $table->enum('day', Helper::$weekDays);
            $table->string('alias')->nullable();
            $table->string('start');
            $table->string('finish');
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
        Schema::dropIfExists('daily_services');
    }
}
