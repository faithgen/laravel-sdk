<?php

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fg_reviews', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('ministry_id', 150)->index();
            $table->enum('type', Helper::$reviewTypes);
            $table->text('review');
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('fg_reviews');
    }
}
