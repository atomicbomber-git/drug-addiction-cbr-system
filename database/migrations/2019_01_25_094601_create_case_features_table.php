<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_features', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('case_id')->unsigned();
            $table->integer('feature_id')->unsigned();
            $table->tinyInteger('value')->default(0);

            $table->foreign('case_id')
                ->references('id')
                ->on('cases');

            $table->foreign('feature_id')
                ->references('id')
                ->on('features');

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
        Schema::dropIfExists('case_features');
    }
}
