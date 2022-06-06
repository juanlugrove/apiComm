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
            $table->integer('idUser', true);
            $table->string('username', 30)->unique('username');
            $table->string('mail', 40)->unique('mail');
            $table->string('password', 25);
            $table->tinyInteger('platform');
            $table->integer('idActualTeam')->nullable()->index('idActualTeam');
            $table->string('logo', 35)->default('defaultUser');
            $table->string('twitter', 50)->nullable();
            $table->string('position', 10)->nullable();
            $table->string('secondPosition', 10)->nullable();
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
