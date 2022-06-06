<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersearchteamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usersearchteam', function (Blueprint $table) {
            $table->foreign(['idUser'], 'usersearchteam_ibfk_1')->references(['idUser'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usersearchteam', function (Blueprint $table) {
            $table->dropForeign('usersearchteam_ibfk_1');
        });
    }
}
