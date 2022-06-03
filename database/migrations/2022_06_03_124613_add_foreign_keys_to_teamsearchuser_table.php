<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTeamsearchuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teamsearchuser', function (Blueprint $table) {
            $table->foreign(['idTeam'], 'teamsearchuser_ibfk_1')->references(['idTeam'])->on('teams')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teamsearchuser', function (Blueprint $table) {
            $table->dropForeign('teamsearchuser_ibfk_1');
        });
    }
}
