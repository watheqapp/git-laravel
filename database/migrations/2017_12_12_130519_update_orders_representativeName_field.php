<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersRepresentativeNameField extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('orders', function ($table) {
            $table->string('clientName', 150)->nullable()->after('delivery');
            $table->string('representativeName', 150)->nullable()->after('delivery');
            $table->string('nationalID', 150)->nullable()->after('delivery');
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
