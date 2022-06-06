<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsearchuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teamsearchuser', function (Blueprint $table) {
            $table->integer('idTeamSU')->primary();
            $table->integer('idTeam')->index('idTeam');
            $table->dateTime('date');
            $table->string('description', 150);
            $table->string('position', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teamsearchuser');
    }
}
