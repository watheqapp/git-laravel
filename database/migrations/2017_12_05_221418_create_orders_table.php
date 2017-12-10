<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('lawyer_id')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->integer('category_id');
            $table->string('cost', 10);
            $table->string('delivery', 10);
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->string('status', 10)->default('New');
            $table->boolean('lock')->default(false);
            $table->boolean('isNotifyNearby10')->default(false);
            $table->boolean('isNotifyNearby20')->default(false);
            $table->bigInteger('created_at_timestamp');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
