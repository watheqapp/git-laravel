<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLawyersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lawyers_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('lawyer_id');
            $table->string('latitude', 20);
            $table->string('longtitude', 20);
            $table->boolean('isAccepted')->default(false);
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
        Schema::dropIfExists('order_lawyers_history');
    }
}
