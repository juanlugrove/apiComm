<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Teamsearchuser
 * 
 * @property int $idTeamSU
 * @property int $idTeam
 * @property Carbon $date
 * @property string $description
 * @property string $position
 * 
 * @property Team $team
 *
 * @package App\Models
 */
class Teamsearchuser extends Model
{
	protected $table = 'teamsearchuser';
	protected $primaryKey = 'idTeamSU';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idTeamSU' => 'int',
		'idTeam' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'idTeam',
		'date',
		'description',
		'position'
	];

	public function team()
	{
		return $this->belongsTo(Team::class, 'idTeam');
	}
}
