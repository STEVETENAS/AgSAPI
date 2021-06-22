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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fName');
            $table->string('lName');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('studId')->unique();
            $table->unsignedBigInteger('idCourse');
            $table->foreign('idCourse')->references('id')->on('courses');
            $table->boolean('admin')->default(false);
            $table->bigInteger('tel')->nullable();
            $table->timestamp("registeredDate")->useCurrent();
            $table->rememberToken();
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
