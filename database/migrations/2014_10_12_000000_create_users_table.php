<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

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
            $table->string('name')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('image', 100)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->boolean('phoneVerified')->default(true);
            $table->string('password')->nullable();
            $table->string('language')->default('ar');
            $table->integer('type')->default(User::$BACKEND_TYPE);
            $table->boolean('admin')->default(false);
            $table->boolean('active')->default(true);
            $table->string('lawyerType', 20)->nullable();
            $table->string('IDCardFile', 100)->nullable();
            $table->string('licenseFile', 100)->nullable();
            $table->softDeletes();
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
