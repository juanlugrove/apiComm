<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersearchteamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersearchteam', function (Blueprint $table) {
            $table->integer('idUserST', true);
            $table->integer('idUser')->index('idUser');
            $table->dateTime('date');
            $table->string('description', 100);
            $table->string('video', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usersearchteam');
    }
}
