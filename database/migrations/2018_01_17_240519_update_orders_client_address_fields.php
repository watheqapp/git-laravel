<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersClientAddressFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function ($table) {
            $table->text('address')->nullable();
            $table->string('time', 200)->nullable();
            $table->string('distance', 200)->nullable();
        });

        Schema::table('users', function ($table) {
            $table->integer('totalOrders')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
