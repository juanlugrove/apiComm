<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTeamusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teamusers', function (Blueprint $table) {
            $table->foreign(['idTeam'], 'teamusers_ibfk_1')->references(['idTeam'])->on('teams')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teamusers', function (Blueprint $table) {
            $table->dropForeign('teamusers_ibfk_1');
        });
    }
}
